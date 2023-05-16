<template>
    <div class="header-left">
      <a href="/#/home">
        <span>山东数字农业管理系统</span>
      </a>
    </div>
    <div class="header-right right">
      <el-dropdown class="el-dropdown-right">
        <span class="el-dropdown-link">
          <el-icon><Avatar /></el-icon>
         <span style="position: relative;top: -1px;left: 3px">
           {{ userInfo?userInfo.username:'' }}
            <el-icon class="el-icon--right">
              <arrow-down />
            </el-icon>
         </span>
<!--          <i class="el-icon-arrow-down el-icon&#45;&#45;right"></i>-->
        </span>
        <template #dropdown style="display: block">
          <el-dropdown-menu>
            <el-dropdown-item command="refreshRule" @click="refreshRule">刷新权限</el-dropdown-item>
            <el-dropdown-item command="logout" @click="clickLogout">退出登录</el-dropdown-item>
          </el-dropdown-menu>
        </template>
      </el-dropdown>
    </div>
</template>

<script>

import {useRouter} from "vue-router";
import { ArrowDown } from '@element-plus/icons-vue'
import storage from "store2";
import {ElMessage} from "element-plus";
import {Logout} from "../api/login";
import {getUserMenus} from "../api/user";
import {getHomeStats} from "../api/home";
import {reactive, toRefs} from "vue";

export default {
  name:'top',
  props: ['userInfo'],
  setup(){
    const state =reactive({
      cargo_yj:0,
    })
    const router = useRouter();//初始化路由
    const clickLogout= ()=> {
      storage.set('isLogin',false);
      storage.set('user_token','');
      storage.set('menuInfo',{});
      storage.set('userInfo',{});
      Logout().then((res)=> {
        console.log(res)
        ElMessage({
          type:'success',
          message: '退出成功',
        });
        router.push({path: '/login'})
      }).catch((err)=>{
        console.log(err)
      })
    }
    const refreshRule = ()=>{
      let user = storage.get('userInfo');
      getUserMenus({
        user_id:user.id
      }).then((res)=>{
        let userInfo = res.Data;
        storage.set('userInfo', userInfo);
        storage.set('menuInfo', userInfo.expend);
        ElMessage({
          type:'success',
          message: '权限刷新成功！',
        })
        setTimeout(function (){
          window.location.reload(true);
        },500)
      })
    }
    return{
      ...toRefs(state),
      clickLogout,
      refreshRule
    }
  },

};
</script>

<style lang="less" scoped>
.header-left{
  float: left;
  display: block;
  height: 45px;
  width: 320px;
}
.header-left img{
  float: left;
  width: 156px!important;
  margin-top: 10px!important;
  margin-left:8px!important;
}
.header-left span{
  display: block;
  font-size: 14px;
  height: 50px;
  line-height: 53px;
}
.header-right{
  height: 50px;
  display: flex;
}
.item-right{
  height: 50px;
  line-height: 28px;
  float: right;
  margin-top: 10px;
  font-size: 14px;
  color: #606266;
}
.el-dropdown-link:focus {
  outline: none;
}
.el-icon--right{
  margin-left:-2px;
  top:2px
}

</style>
