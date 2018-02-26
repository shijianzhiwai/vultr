<template>
    <el-dialog
            title="提示"
            :visible.sync="share.dialogVisible"
            width="30%"
    >
        <span>{{ share.dialogVal.info }}</span>
        <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="share.dialogVisible = false">确 定</el-button>
    </span>
    </el-dialog>
</template>

<script>
    export default {
        data() {
            return {};
        },
        props: ['share'],
    };
</script>