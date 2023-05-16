<template>
    <!--default-active的值与菜单中index的值一致即可选中 :index="(index).toString()"-->
    <el-menu :uniqueOpened="true" :default-openeds="['0']" :default-active="$route.meta.name" router>
        <el-sub-menu :key="item.id" :index="(index).toString()" v-for="(item,index) in menuInfo.menuList">
            <template #title>
                <img class="icon-all" :src="'images/'+item.icon+'.svg'" alt="icon"/>
                <span style="margin-left: 20px">
                {{ item.title }}
        </span>
            </template>
            <div :key="item_c.id" v-for="(item_c,s_index) in item.children">
                <el-menu-item :route="{path:item_c.rule}" :index="item_c.rule">{{ item_c.title }}
                </el-menu-item>
            </div>
        </el-sub-menu>
    </el-menu>
</template>
<script>
export default {
    name: 'left',
    props: ['menuInfo'],
    setup() {
        const handleSelect = (index, indexPath) => {
            console.log(index);
            console.log(indexPath)
        }
        return {
            handleSelect
        }
    },

};
</script>
<style lang="less" scoped>
.el-sub-menu__title {
  .icon-all {
    filter: drop-shadow(#2F3335 100px 0);
    transform: translateX(-100px);
  }

  &:hover {
    .icon-all {
      filter: drop-shadow(#00c454 100px 0)
    }
  ;
  }
}
</style>
