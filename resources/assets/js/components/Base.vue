<template>
    <el-container style="border: 1px solid #eee; height: 100vh">
        <el-aside width="200px" style="background-color: rgb(238, 241, 246);">
            <el-menu :default-openeds="['1']">
                <el-submenu index="1">
                    <template slot="title"><i class="el-icon-setting"></i>防火墙</template>
                    <el-menu-item-group>
                        <template slot="title">防火墙组</template>
                        <template v-for="(fire, id) in fires">
                            <el-menu-item :key="id" :index="id">{{ fire.FIREWALLGROUPID }}({{ fire.description }})
                            </el-menu-item>
                        </template>
                    </el-menu-item-group>
                </el-submenu>
            </el-menu>
        </el-aside>

        <el-container>
            <el-header style="text-align: right; font-size: 12px">
                <el-dropdown>
                    <i class="el-icon-setting" style="margin-right: 15px"></i>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item>查看</el-dropdown-item>
                        <el-dropdown-item>新增</el-dropdown-item>
                        <el-dropdown-item>删除</el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
                <span>{{ user.name }}</span>
            </el-header>

        </el-container>
    </el-container>
</template>
<style>
    .el-header {
        background-color: #B3C0D1;
        color: #333;
        line-height: 60px;
    }

    .el-aside {
        color: #333;
    }
</style>

<script>
    async function getData() {
        try {
            const response = await axios.get('/api/vultr/fire_list');
            return response.data.data;
        } catch (error) {
            console.log(error);
            return {};
        }
    }

    async function getUser() {
        try {
            const response = await axios.get('/api/vultr/user');
            return response.data.data;
        } catch (error) {
            console.log(error);
            return {};
        }
    }

    export default {
        data() {
            getData().then(
                result => {
                    this.fires = result
                }
            );
            getUser().then(
                result => {
                    this.user = result
                }
            );
            const item = {
                date: '2016-05-02',
                name: '王小虎',
                address: '上海市普陀区金沙江路 1518 弄'
            };
            return {
                tableData: Array(20).fill(item),
                fires: {'error': {description: "...", FIREWALLGROUPID: "加载中"}},
                user: {name: "加载中..."}
            }
        },
        methods: {
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            }
        }
    };
</script>