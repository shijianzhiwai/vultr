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
            <!--<el-table-column-->
                    <!--fixed="right"-->
                    <!--label="操作"-->
                    <!--width="120">-->
                <!--<template slot-scope="scope">-->
                    <!--<el-button-->
                            <!--plain-->
                            <!--@click.native.prevent="deleteFire(scope.$index, tableData4)"-->
                            <!--type="warning"-->
                            <!--size="small">-->
                        <!--删除-->
                    <!--</el-button>-->
                <!--</template>-->
            <!--</el-table-column>-->
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
            deleteFire() {

            }
        },
        watch: {
            '$route': 'refreshData'
        },
        data() {
            return {
                tableData: [],
                loading:true
            }
        },
        created() {
            this.refreshData();
        }
    }
</script>