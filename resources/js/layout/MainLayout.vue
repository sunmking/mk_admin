<template>
  <el-config-provider :locale="locale">
    <el-container >
      <el-header >
        <!--header-->
        <HeaderLayout :userInfo="userInfo"></HeaderLayout>
      </el-header>
      <el-container>
        <el-aside>
          <!--左侧菜单-->
          <LeftLayout :menuInfo="menuInfo"></LeftLayout>
        </el-aside>
        <el-main>
          <!--面包屑-->
          <Breadcrumb :menuInfo="menuInfo"></Breadcrumb>
          <!--内容区-->
          <router-view/>
        </el-main>
      </el-container>
    </el-container>
  </el-config-provider>
</template>
<script>
import HeaderLayout from "../components/Header.vue"
import LeftLayout  from "../components/Left.vue"
import Breadcrumb  from "../components/Breadcrumb"
import storage  from "store2"
import {ElConfigProvider} from "element-plus";
import zhCn from 'element-plus/lib/locale/lang/zh-cn'
export default {
  name:'indexLayout',
  components:{
    [ElConfigProvider.name]: ElConfigProvider,
    HeaderLayout,
    LeftLayout,
    Breadcrumb
  },
  setup(){
    return{
      userInfo: storage.get('userInfo')||{},
      menuInfo: storage.get('menuInfo')||[],
    }
  },
  data() {
    return {
      locale: zhCn,
    }
  },
};
</script>

<style lang="less" scoped>
</style>
