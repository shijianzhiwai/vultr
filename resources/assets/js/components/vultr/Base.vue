<template>
    <el-container style="border: 1px solid #eee; height: 100vh">
        <el-aside width="200px" style="background-color: rgb(238, 241, 246);">
            <el-menu :default-openeds="['1']" :router="true" @select="handleSelect">
                <el-submenu index="1">
                    <template slot="title"><i class="el-icon-setting"></i>防火墙</template>
                    <el-menu-item-group>
                        <template slot="title">防火墙组</template>
                        <template v-for="(fire, id) in fires">
                            <el-menu-item :route="{path:'/fire_info/' + fire.FIREWALLGROUPID }" :key="id" :index="id">{{ fire.FIREWALLGROUPID }}({{
                                fire.description }})
                            </el-menu-item>
                        </template>
                    </el-menu-item-group>
                </el-submenu>
            </el-menu>
        </el-aside>

        <el-container>
            <el-header height="40px" style="text-align: right; font-size: 12px;">
                <el-dropdown @command="handleCommand">
                    <i class="el-icon-more" style="margin-right: 15px"></i>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item command="home">返回首页</el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
                <span>{{ user.name }}</span>
            </el-header>
            <el-main>
                <router-view></router-view>
            </el-main>
        </el-container>
    </el-container>
</template>
<style>
    .el-header {
        background-color: #E9EEF3;
        color: #333;
        line-height: 40px;
    }

    .el-aside {
        color: #333;
    }
</style>

<script>

    async function getData() {
        try {
            const response = await window.axios.get('/api/vultr/fire_list');
            return response.data.data;
        } catch (error) {
            console.log(error);
            return {};
        }
    }

    async function getUser() {
        try {
            const response = await window.axios.get('/api/vultr/user');
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


            return {
                fires: {'error': {description: "...", FIREWALLGROUPID: "加载中"}},
                user: {name: "加载中..."},
            }
        },
        methods: {
            handleCommand(command) {
                if (command === 'home') {
                    window.location.href = '/home';
                }
            },
            handleSelect(key, keyPath){
                // console.log(key)
            }
        }
    };
</script>