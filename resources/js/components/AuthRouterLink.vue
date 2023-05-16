<template>
  <router-link :to="to" v-if="isShow">
    <el-button :type="type_data" :size="size_data" :disabled="is_disable" :loading="is_loading" @click="handleClick" size="small">{{text}}</el-button>
  </router-link>
</template>
<script>
import {ref, toRefs} from "vue";
import storage from "store2";

export default {
  name: "AuthRouterLink",
  props: ['text', 'type','size','route_name','isDisable','isLoading'],
  emits: ["handleClick"],
  setup(props, context) {
    let isShow = ref(false)
    let is_disable = ref(false)
    let is_loading = ref(false)
    let size_data = ref('')
    let type_data = ref('')
    // 其中props是响应式不能随便使用es6解构，context不是响应式可以使用es6解构
    let {text, type,size,to,route_name,isDisable,isLoading} = toRefs(props); // 将props转化为响应式，因为 props 是响应式的，你不能使用 ES6 解构，因为它会消除 prop 的响应性。
    is_disable.value = (isDisable===true);
    is_loading.value = (isLoading===true);
    size_data.value = size.value||'mini';
    type_data.value = type.value||'default';
    let handleClick = () => {
      //console.log(props, context);
      context.emit("handleClick");
    };

    const isShowButton=()=> {
      let menuInfo = storage.get('menuInfo') || [];
      let menuList = menuInfo.menuList;
      //菜单
      if (menuList.length > 0) {
        for (let i = 0; i < menuList.length; i++) {
          let currentMenu = menuList[i];

          (currentMenu.children || []).every((item_c) => {
            if (item_c.rule === route_name.value) { //eg /unit/index
              isShow.value = true
              return false;
            } else {
              let data_cc = item_c.children || [];
              data_cc.every((item_cc) => {
                if (item_cc.rule === route_name.value) {
                  isShow.value = true
                  return false;
                }
                return true;
              });
            }
            return true;
          });
        }
      }
    };
    isShowButton();
    return {
      isShowButton,
      handleClick,
      isShow,
      text,
      to,
      type_data,
      size_data,
      is_disable,
      is_loading
    };
  }
}
</script>

<style scoped>

</style>