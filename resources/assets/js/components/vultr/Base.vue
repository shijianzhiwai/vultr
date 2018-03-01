<template>
    <el-container style="border: 1px solid #eee; height: 100vh">
        <el-aside width="200px" style="background-color: rgb(238, 241, 246);">
            <el-menu
                    :default-active="this.$route.path"
                    router
                    unique-opened>
                <el-submenu index="1" key="1">
                    <template slot="title"><i class="el-icon-setting"></i>防火墙</template>
                    <el-menu-item-group>
                        <template slot="title">防火墙组</template>
                        <template v-for="(fire, id) in fires" >
                            <el-menu-item :key = "id" :index="'/fire_info/' + fire.FIREWALLGROUPID">{{ fire.FIREWALLGROUPID }}({{
                                fire.description }})
                            </el-menu-item>
                        </template>
                    </el-menu-item-group>
                </el-submenu>
                <el-submenu index="2" key="2">
                    <template slot="title"><i class="el-icon-setting"></i>IP</template>
                    <el-menu-item-group>
                        <el-menu-item :index="'/ip/list'">IP列表</el-menu-item>
                    </el-menu-item-group>
                </el-submenu>
            </el-menu>
        </el-aside>

        <el-container>
            <el-header height="40px" style="text-align: right; font-size: 12px;">
                <header-tpl></header-tpl>
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
    import headerTpl from './Header.vue';
    import ElHeader from "element-ui/packages/header/src/main";

    async function getData() {
        try {
            const response = await window.axios.get('/api/vultr/fire_list');
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

            return {
                fires: {'error': {description: "...", FIREWALLGROUPID: "加载中"}},
            }
        },
        components: {
            ElHeader,
            headerTpl
        },
        methods: {

        }
    };
</script>