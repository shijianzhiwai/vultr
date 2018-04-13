<template>
    <el-container>
        <el-header height="100%" style="background-color: #FFFFFF;padding-left: 8px;">
            <el-button @click="addIp">增加IP信息</el-button>
        </el-header>
        <el-table
                :data="tableData"
                style="width: 100%"
                stripe
                v-loading="loading">
            <el-table-column
                    prop="id"
                    label="id">
            </el-table-column>
            <el-table-column
                    prop="ip"
                    label="ip">
            </el-table-column>
            <el-table-column
                    prop="remark"
                    label="remark">
            </el-table-column>
            <el-table-column
                    prop="created_at"
                    label="created_at">
            </el-table-column>
            <el-table-column
                    label="edit">
                <template slot-scope="scope">
                    <el-button @click="editIp(scope.$index, scope.row.id)" type="primary"
                               icon="el-icon-edit"
                               circle></el-button>
                    <el-button @click="deleteIp(scope.$index , scope.row.id)" type="danger"
                               icon="el-icon-delete"
                               circle></el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-dialog :title="title" :visible.sync="editOpen" width="500px" center>
            <el-form ref="form" :model="form" label-width="80px">
                <el-form-item label="ID" v-if="!addFlag">
                    <el-input v-model="form.id" :disabled="true"></el-input>
                </el-form-item>
                <el-form-item label="IP">
                    <div style="height: 40px;width: 100%">
                        <div style="width: 70%;float: left">
                            <span><el-input v-model="form.ip" maxlength="40px"></el-input></span>
                        </div>
                        <div style="float: right">
                            <span><el-button @click="getIp">本机IP</el-button></span>
                        </div>
                    </div>
                </el-form-item>
                <el-form-item label="remark">
                    <el-input v-model="form.remark"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="editOpen = false">取 消</el-button>
                <el-button type="primary" @click="putIp(form.index)">确 定</el-button>
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
</style>

<script>
    import {getIpData} from "../../func.js";

    async function reqAddIp(form) {
        try {
            let params = new URLSearchParams();
            params.append('ip', form.ip);
            params.append('remark', form.remark);
            const response = await window.axios.post('/api/vultr/ips', params, {
                headers:
                    {'Content-Type': 'application/x-www-form-urlencoded'}
            });
            return response.data;
        } catch (error) {
            console.log(error);
            return 500;
        }
    }

    async function reqDeleteIp(id) {
        try {
            const response = await window.axios.delete('/api/vultr/ips/' + id);
            return response.data;
        } catch (error) {
            console.log(error);
            return 500;
        }
    }

    async function reqEditIp(form) {
        try {
            let params = new URLSearchParams();
            params.append('ip', form.ip);
            params.append('remark', form.remark);
            const response = await window.axios.put('/api/vultr/ips/' + form.id, params, {
                headers:
                    {'Content-Type': 'application/x-www-form-urlencoded'}
            });
            return response.data;
        } catch (error) {
            console.log(error);
            return 500;
        }
    }

    async function getIp() {
        try {
            const response = await window.axios.get('/my_ip');
            return response.data;
        } catch (error) {
            console.log(error);
            return 500;
        }
    }

    export default {
        methods: {
            refreshData() {
                this.loading = true;
                getIpData().then(
                    result => {
                        this.tableData = Object.keys(result).map(key => result[key]);
                        this.loading = false;
                    }
                );
            },
            getIp() {
                getIp().then(result => {
                    if (result === 500) {
                        this.$message('获取失败');
                    } else {
                        this.$message('获取成功');
                        this.form.ip = result;
                    }
                })
            },
            deleteIp(index, id) {
                this.$confirm("确认删除？", '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$message('删除中...');
                    reqDeleteIp(id).then(
                        res => {
                            if (res === 500) {
                                return;
                            }
                            this.tableData.splice(index, 1);
                            this.$message({
                                type: 'success',
                                message: '删除成功!'
                            });
                        }
                    )
                }).catch(() => {

                });
            },
            addIp() {
                this.addFlag = true;
                this.editOpen = true;
                this.title = "添加";
                this.form = {
                    id : "自动生成",
                    ip: "",
                    remark: "",
                };
            },
            editIp(index) {
                this.addFlag = false;
                this.editOpen = true;
                this.title = "编辑";
                //拷贝数据
                this.form = Object.assign({}, this.tableData[index]);
                this.form.index = index;
            },
            putIp(index) {
                this.editOpen = false;
                if (this.addFlag) {
                    this.$message('添加中...');
                    reqAddIp(this.form).then(
                        res => {
                            if (res === 500) {
                                return;
                            }
                            let data = res.data.data;
                            this.tableData.push({
                                id: data.id,
                                ip: data.ip,
                                remark: data.remark,
                                created_at: data.created_at,
                            });

                            this.$message({
                                type: 'success',
                                message: '添加成功!'
                            });
                        }
                    );
                } else {
                    this.$message('更新中...');
                    reqEditIp(this.form).then(
                        res => {
                            if (res === 500) {
                                return;
                            }
                            let cache = this.tableData[index];
                            cache.ip = this.form.ip;
                            cache.remark = this.form.remark;

                            this.$message({
                                type: 'success',
                                message: '更新成功!'
                            });
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
                form: {},
                addFlag: false,
                title:"",
            }
        },
        created() {
            this.refreshData();
        }
    }
</script>