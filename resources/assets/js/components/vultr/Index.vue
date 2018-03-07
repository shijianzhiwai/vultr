<template>
    <el-container>
        <el-main>
            <el-progress type="circle" :percentage="percentage" :status ="status"></el-progress>
        </el-main>
    </el-container>
</template>

<script>

    export default {
        data() {

            let int_id = setInterval(() => {
                let c = this.percentage + 10;
                if (c >= 100) {
                    this.percentage = 100;
                    clearInterval(int_id);
                    this.status = 'success';
                    return;
                }
                this.percentage = c;
            }, 1000);

            return {
                percentage: 11,
                status: null,
            }
        },
    }
</script>