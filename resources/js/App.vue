<template>
  <div id="app">
    <el-config-provider :size="size" :z-index="zIndex">
      <component :is="layout">
        <router-view></router-view>
      </component>
    </el-config-provider>
  </div>
</template>


<script>
import DefaultLayout from './layout/Layout';
import MainLayout from './layout/MainLayout';
import EmptyLayout from './layout/EmptyLayout';
import { defineComponent } from 'vue';
import { ElConfigProvider } from 'element-plus';
export default {
  name: 'app',
  components:{
    'default-layout':DefaultLayout,
    'main-layout':MainLayout,
    'empty-layout':EmptyLayout,
    ElConfigProvider,
  },
  setup(){
  },
  data () {
    return {
      visible: false,
      default_layout:'empty',
      zIndex: 3000,
      size: 'small',
    }
  },
  computed: {
    layout(){
      console.log(this.$route.meta.layout)
      return (this.$route.meta.layout || this.default_layout) + '-layout'
    }
  }
};
</script>

<style>
body {
  font-size: 16px;
  background-color: #f8f8f8;
  -webkit-font-smoothing: antialiased;
}
</style>
