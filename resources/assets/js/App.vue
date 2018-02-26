<template>
    <div id="app" style="height: 100vh" >
        <dialog-tpl :share="share"></dialog-tpl><!-- 弹窗组件 -->
        <base-tpl></base-tpl>
    </div>
</template>
<script>
  import baseTpl from './components/Base.vue';
  import dialogTpl from './vultr/Dialog.vue';

  export default {
    name: 'app',
    props: ['share'],
    components: {
      baseTpl,
      dialogTpl
    },
    data() {
      console.log(this);
      return {}
    }
  };
</script>