<template>
    <el-container>
        <el-header height="100%" style="background-color: #FFFFFF;padding-left: 8px;">
            <el-button @click="addFire">增加防火墙信息</el-button>
        </el-header>
        <el-table
                :data="tableData"
                style="width: 100%"
                stripe
                v-loading="loading">
            <el-table-column
                    prop="rulenumber"
                    label="rulenumber">
            </el-table-column>
            <el-table-column
                    prop="action"
                    label="action">
            </el-table-column>
            <el-table-column
                    prop="protocol"
                    label="protocol">
            </el-table-column>
            <el-table-column
                    prop="port"
                    label="port">
            </el-table-column>
            <el-table-column
                    prop="subnet"
                    label="subnet">
            </el-table-column>
            <el-table-column
                    prop="subnet_size"
                    label="subnet_size">
            </el-table-column>
            <el-table-column
                    prop="remark"
                    label="remark">
            </el-table-column>
            <el-table-column
                    fixed="right"
                    label="edit"
                    width="120">
                <template slot-scope="scope">
                    <el-button @click="editFire(scope.$index)" type="primary"
                               icon="el-icon-edit"
                               circle></el-button>
                    <el-button @click="deleteFire(scope.$index , scope.row.rulenumber)" type="danger"
                               icon="el-icon-delete"
                               circle></el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-dialog :title="title" :visible.sync="editOpen" width="500px" center>
            <el-form ref="form" :model="form" label-width="80px">
                <el-row style="margin-left:80px;line-height:40px;">
                    <el-button @click="tip('SSR')" size="mini">SSR</el-button>
                    <el-button @click="tip('SSH')" size="mini">SSH</el-button>
                </el-row>
                <el-form-item label="rulenumber" v-if="isEdit">
                    <el-input v-model="form.rulenumber" :disabled="true"></el-input>
                </el-form-item>
                <el-form-item label="protocol">
                    <el-select @change="protocolChange" class="select" v-model="form.protocol" placeholder="请选择">
                        <el-option
                                v-for="item in protocols"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="port">
                    <el-input :disabled="portOpen" v-model="form.port"></el-input>
                </el-form-item>
                <el-form-item label="subnet">
                    <el-select class="select" v-model="form.subnet" placeholder="请选择">
                        <el-option
                                v-for="item in subnets"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="subnet_size">
                    <el-input v-model="form.subnet_size"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="editOpen = false">取 消</el-button>
                <el-button type="primary" @click="putRule(form.index)">确 定</el-button>
            </div>
        </el-dialog>
    </el-container>
</template>
<style>
    .el-table .warning-row {
        background: oldlace;
    }

    .el-table .success-row {
        background: #f0f9eb;
    }

    .select {
        width: 100%;
    }
</style>

<script>
    import {getIpData} from "../../func.js";

    async function getData(id) {
        try {
            const response = await window.axios.get('/api/vultr/rule_list?fireid=' + id);
            return response.data.data;
        } catch (error) {
            console.log(error);
            return {};
        }
    }

    async function addRule(form, fireid) {
        try {
            let params = new URLSearchParams();
            params.append('port', form.port);
            params.append('fireid', fireid);
            params.append('protocol', form.protocol);
            params.append('subnet', form.subnet);
            params.append('subnet_size', form.subnet_size);
            const response = await window.axios.post('/api/vultr/rule_add', params, {
                header: {'Content-Type': 'application/x-www-form-urlencoded'},
            });
            return response.data;
        } catch (error) {
            console.log(error);
            return 500;
        }
    }

    async function deleteRule(id, rule) {
        try {
            const response = await window.axios.post('/api/vultr/rule_delete', {
                fireid: id,
                rulenumber: rule
            });
            return response.data.data;
        } catch (error) {
            console.log(error);
            return 500;
        }
    }

    function msgOpen(that, info, index, rule) {
        that.$confirm(info, '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
        }).then(() => {
            that.$message('删除中...');
            deleteRule(that.$route.params.fireid, rule).then(
                res => {
                    if (res === 500) {
                        return;
                    }
                    that.tableData.splice(index, 1);
                    that.$message({
                        type: 'success',
                        message: '删除成功!'
                    });
                }
            );
        }).catch(() => {

        });
    }

    export default {
        methods: {
            tip(tip){
                if (tip === 'SSR') {
                    this.form.port = '57483';
                    this.form.protocol = "tcp";
                } else if(tip === 'SSH') {
                    this.form.port = '22';
                    this.form.protocol = "tcp";
                }
            },
            refreshData() {
                this.loading = true;
                getData(this.$route.params.fireid).then(
                    result => {
                        this.tableData = Object.keys(result).map(key => result[key]);
                        this.loading = false;
                    }
                );
            },
            deleteFire(index, rule) {
                msgOpen(this, "确认删除编号为" + rule + "的防火墙规则？", index, rule)
            },
            editFire(index) {
                this.editOpen = true;
                this.isEdit = true;
                this.form = Object.assign({}, this.tableData[index]);
                this.form.index = index;
                this.form.protocol === 'icmp' ? this.portOpen = true : this.portOpen = false;
                this.subnets = []; //重新初始化
                this.title = "编辑";
                getIpData().then(
                    result => {
                        Object.keys(result).forEach(key => {
                            this.subnets.push({
                                label: result[key].ip + `(${result[key].remark})`,
                                value: result[key].ip
                            })
                        });
                        this.subnets.push({
                            label: '0.0.0.0(all)',
                            value: '0.0.0.0'
                        });
                    }
                );
            },
            protocolChange() {
                this.form.protocol === 'icmp' ? this.portOpen = true : this.portOpen = false;
            },
            addFire() {
                this.editOpen = true;
                this.isEdit = false;
                this.form.protocol = "";
                this.form.subnet = "";
                this.form.port = "";
                this.form.index = 0;
                this.form.subnet_size = 32;
                this.subnets = []; //重新初始化
                this.title = "添加";
                getIpData().then(
                    result => {
                        Object.keys(result).forEach(key => {
                            this.subnets.push({
                                label: result[key].ip + `(${result[key].remark})`,
                                value: result[key].ip
                            })
                        });
                        this.subnets.push({
                            label: '0.0.0.0(all)',
                            value: '0.0.0.0'
                        });
                    }
                );
            },
            putRule(index) {
                this.editOpen = false;
                if (index === 0) { //证明是添加状态
                    this.$message('添加中...');
                    addRule(this.form, this.$route.params.fireid).then(
                        res => {
                            if (res === 500) {
                                return;
                            }
                            this.$message({
                                type: 'success',
                                message: '添加成功'
                            });

                            //刷新列表
                            this.refreshData();
                        }
                    )
                } else {
                    //证明是编辑状态
                    this.$message('删除中...');
                    deleteRule(this.$route.params.fireid, this.form.rulenumber).then(
                        res => {
                            if (res === 500) {
                                return;
                            }
                            this.$message({
                                type: 'success',
                                message: '删除成功! => 正在添加...'
                            });
                            addRule(this.form, this.$route.params.fireid).then(
                                res => {
                                    if (res === 500) {
                                        return;
                                    }
                                    this.$message({
                                        type: 'success',
                                        message: '添加成功'
                                    });

                                    //刷新列表
                                    this.refreshData();
                                }
                            )
                        }
                    );
                }
            }
        },
        watch: {
            '$route': 'refreshData'
        },
        data() {
            return {
                tableData: [],
                loading: true,
                editOpen: false,
                isEdit: false,
                form: {
                    subnet: "",
                    port:"",
                    index:0,
                    subnet_size:32,
                    protocol:""
                },
                subnets: [],
                portOpen: false,
                title:"",
                protocols: [
                    {
                        value: 'icmp',
                        label: 'icmp',
                    },
                    {
                        value: 'tcp',
                        label: 'tcp',
                    },
                    {
                        value: 'udp',
                        label: 'udp',
                    },
                    {
                        value: 'gre',
                        label: 'gre',
                    }
                ],
            }
        },
        created() {
            this.refreshData();
        }
    }
</script>