<template>
    <div id="app" style="height: 100vh" >
        <dialog-tpl :share="share"></dialog-tpl><!-- 弹窗组件 -->
        <base-tpl ></base-tpl>
    </div>
</template>
<script>
  import baseTpl from './Base.vue';
  import dialogTpl from './Dialog.vue';

  export default {
    name: 'app',
    props: ['share'],
    components: {
      baseTpl,
      dialogTpl
    },
    data() {
      return {}
    }
  };
</script>