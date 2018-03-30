<template>
    <el-container>
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
                    <el-button @click="editFire(scope.$index, scope.row.rulenumber)" type="primary"
                               icon="el-icon-edit"
                               circle></el-button>
                    <el-button @click="deleteFire(scope.$index , scope.row.rulenumber)" type="danger"
                               icon="el-icon-delete"
                               circle></el-button>
                </template>
            </el-table-column>
        </el-table>

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

    async function getData(id) {
        try {
            const response = await window.axios.get('/api/vultr/rule_list?fireid=' + id);
            return response.data.data;
        } catch (error) {
            console.log(error);
            return {};
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
            editFire(index, rule) {

            }
        },
        watch: {
            '$route': 'refreshData'
        },
        data() {
            return {
                tableData: [],
                loading: true,
            }
        },
        created() {
            this.refreshData();
        }
    }
</script>