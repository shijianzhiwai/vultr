<template>
    <el-container>
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

    async function getData() {
        try {
            const response = await window.axios.get('/api/vultr/ip_list');
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
                getData().then(
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