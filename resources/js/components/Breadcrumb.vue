<template>
  <el-breadcrumb v-if="breadList.length>2">
    <el-breadcrumb-item  v-for="item in breadList" :key="item.name">
      <router-link v-if="item.is_link" :to="item.name">
        {{item.title}}
      </router-link>
      <span v-else>{{item.title}}</span>
    </el-breadcrumb-item>
  </el-breadcrumb>
</template>

<script>
import { useRoute } from "vue-router";
import {reactive, toRefs} from "vue";

export default {
  name: 'Breadcrumb',
  props:['menuInfo'],
  setup(props){
    const route = useRoute();//初始化路由
    const state = reactive({
      breadList:[]
    });
    const isHome=(route) =>{
      return route.name === "home";
    }
    const getBreadcrumb=()=> {
      let matched = route.matched;
      let list = [];
      let menuList = props.menuInfo.menuList||[];
      let route_name = matched[0];
      //如果不是首页
      if (!isHome(matched[0])) {
        if(menuList.length>0){
          for (let i = 0; i < menuList.length; i++) {
            let currentMenu = menuList[i];
              if ( currentMenu.children){
            (currentMenu.children || []).every((item_c) => {
              if (item_c.rule === route_name.path) { //eg /unit/index
                list.push({name: currentMenu.rule, title: currentMenu.title, is_link: false})
                list.push({name: item_c.rule, title: item_c.title, is_link: true})

              } else {
                let data_cc = item_c.children || [];
                data_cc.every((item_cc) => {
                  if (item_cc.rule === route_name.path) {
                    list.push({name: item_c.rule, title: item_c.title, is_link: true});
                    list.push({name: item_cc.rule, title: item_cc.title, is_link: false})
                  }
                  return true;
                });
              }
              return true;
            });
              }
          }
        }
        list = [{name: "home", title: "首页", is_link: true}].concat(list);
      }else {
        list = [{name: "home", title: "首页", is_link: true}]
      }
      state.breadList = list;
    }
    console.log(state.breadList.length)

    return {
      isHome,
      getBreadcrumb,
      ...toRefs(state)
    }
  },
  watch: {
    $route: {
      handler() {
        this.getBreadcrumb()
      },
      deep:true,
      immediate: true
    }
  },
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
