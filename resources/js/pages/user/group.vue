<template>
  <div class="card-wrap">
    <div class="card-header">
      <span class="card-title">分配角色</span>
      <span class="right">
        <el-button type="primary" @click="saveAll" :disabled="isDisabled" size="small" class="ml-1" plain>保存</el-button>
      </span>
    </div>
    <div class="card-body-blank">
      <el-table
          :data="groupList"
          border
          header-row-class-name="table-header-th"
          size="small"
          height="500"
          style="width: 100%"
          ref="multipleTable"
          @selection-change="handleSelectionChange">
        <el-table-column
            width="60"
            type="selection">
        </el-table-column>
        <el-table-column
            width="60"
            prop="id"
            align="center"
            label="编号">
        </el-table-column>
        <el-table-column
            width="120"
            align="center"
            prop="name"
            label="角色">
        </el-table-column>
        <el-table-column
            align="center"
            label="权限范围">
          <template #default="scope">
            <el-tooltip
                placement="top"
                width="200"
                trigger="hover">
              <template #content>
                {{scope.row.group_rules}}
              </template>
              <span>{{stringSub(scope.row.group_rules,48)}}</span>
            </el-tooltip>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </div>
</template>
<script>
import {reactive, ref, toRefs} from "vue";
import {ElMessage} from "element-plus";
import {getGroupList} from "../../api/group";
import {getUserDetail, saveUserGroupData} from "../../api/user";
import {useRoute, useRouter} from "vue-router";

export default {
  setup(){
    const router = useRouter();
    const route = useRoute();
    const state = reactive({
      groupList: [],
      userInfo:[],
      multipleSelection:[]
    });
    const getLists = ()=>{
      let params={
        type:'all',
      }
      getGroupList(params).then((result)=>{
        state.groupList = result.Data
        getUserDetails(route.query.id)
      })
    }
    const handleSelectionChange = (val)=> {
        state.multipleSelection = val;
    }
    const multipleTable = ref(null)
    const toggleSelection = (row)=> {
      if(row){
        multipleTable._value.toggleRowSelection(row);
      }
    }
    const getUserDetails = (id)=>{
      let params={
        type:'detail',
        id:id,
      }
      getUserDetail(params).then((result)=>{
        state.userInfo = result.Data||[]
        let uGroupIds = state.userInfo.group_ids
        console.log(uGroupIds)

        state.groupList.every(function (item){
              if(uGroupIds.indexOf(item.id)>-1){
                toggleSelection(item)
              }
              return true;
        });

        console.log(state.userInfo)
      })
    }
    const saveAll = () => {
      console.log(state.multipleSelection)
        let groupData_ids = [];
        state.multipleSelection.every(function (item){
          groupData_ids.push(item.id)
          return true;
        });
        console.log(groupData_ids)
        state.body_loading = true;
        state.save_loading = true;
        saveUserGroupData({
          id:route.query.id,
          group_ids:groupData_ids,
        }).then((res)=>{
          state.body_loading = false;
          state.save_loading = false;

          ElMessage({
            type: 'success',
            message: res.Msg,
            duration: 1000,
          });
          setTimeout(function (){
            router.push({
              path:'/user/list'
            })
          });
        })

    }
    getLists()
    return {
      ...toRefs(state),
      handleSelectionChange,
      saveAll,
      multipleTable,
      getLists
    }
  }
};
</script>