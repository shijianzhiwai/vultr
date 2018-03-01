<template>
    <el-row>
        <el-col>
            <el-dropdown @command="handleCommand">
                <i class="el-icon-more" style="margin-right: 15px"></i>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item command="home">返回首页</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
            <span>{{ user.name }}</span>
        </el-col>
    </el-row>
</template>

<script>

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

            getUser().then(
                result => {
                    this.user = result
                }
            );

            return {
                user: {name: "加载中..."},
            };
        },
        methods: {
            handleCommand(command) {
                if (command === 'home') {
                    window.location.href = '/home';
                }
            }
        },
    }
</script>