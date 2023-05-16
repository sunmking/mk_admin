<template>

  <div class="card-wrap">
    <div class="search-data">
      <div class="card-header">
        <span class="card-title">账号管理</span>
        <span class="right">
        <auth-router-link :to="{path:'/user/detail',query:{id:0}}" type="primary" size="small" text="添加" :route_name="'/user/detail'"></auth-router-link>
      </span>
      </div>
      <div class="card-body">
        <el-form :inline="true" :model="searchInfo" size="small" class="demo-form-inline">
            <span class="total_length">
                <el-form-item label="账号">
                    <el-input v-model="searchInfo.username" placeholder="账号" size="small" class="input_length" clearable></el-input>
                </el-form-item>
            </span>
          <span class="total_length">
                <el-form-item label="姓名">
                    <el-input v-model="searchInfo.name" placeholder="姓名" size="small" class="input_length" clearable></el-input>
                </el-form-item>
            </span>
          <span class="total_length">
               <el-form-item label="角色">
                    <el-select v-model="searchInfo.group_id" placeholder="角色" size="small" class="input_length" clearable>
                        <el-option
                            v-for="item in groupList"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </span>
          <el-form-item>
            <el-button type="primary" @click="getLists(1)" size="small">搜索</el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
    <div style="width: 100%;border-bottom: 10px solid #F4F4F4;"></div>
    <div class="card-body-blank">
        <el-table
            :data="userList"
            fit
            border
            highlight-current-row
            header-row-class-name="table-header-th"
            size="small"
            height="500" style="width: 100%">
          <el-table-column
              prop="id"
              label="编号"
              align="center"
              width="50">
          </el-table-column>
          <el-table-column
              prop="username"
              align="center"
              label="账号" width="160">
          </el-table-column>
          <el-table-column
              prop="name"
              align="center"
              label="姓名" width="160">
          </el-table-column>
          <el-table-column
              prop="group_name"
              align="center"
              label="角色" width="160">
          </el-table-column>
          <el-table-column
              prop="status"
              align="center"
              label="启用" width="100">
            <template #default="scope">
              <span>{{statusFilter(scope.row.status)}}</span>
            </template>
          </el-table-column>
          <el-table-column
              label="操作"
              width="220"
              align="center">
            <template #default="scope">
              <router-link :to="{path:'/user/group',query:{id:scope.row.id}}">
                <el-button size="small" class="mr-1" plain>设置角色</el-button>
              </router-link>
              <router-link :to="{path:'/user/detail',query:{id:scope.row.id}}">
                <el-button size="small">编辑</el-button>
              </router-link>
            </template>
          </el-table-column>
        </el-table>
    </div>

    <div class="card-footer">
      <div class="right">
        <el-pagination
            small
            background
            @current-change="getLists"
            :current-page.sync="current"
            :page-size="display"
            layout="prev, pager, next, jumper"
            :total="total">
        </el-pagination>
      </div>
    </div>
  </div>
</template>
<script>
import {reactive, toRefs} from "vue";
import {ElMessage, ElMessageBox} from "element-plus";
import {deleteUserData, getUserList} from "../../api/user";
import {getGroupList} from "../../api/group";
import AuthRouterLink from "../../components/AuthRouterLink";

export default {
  components: {AuthRouterLink},
  setup(){
    const state = reactive({
      total: 0,     // 记录总条数
      display: 20,   // 每页显示条数
      current: 1,     // 当前第n页 ， 也可以 watch current 的变化
      searchInfo: {
        username: '',
        name: '',
        group_id: ''
      },
      userList:[],
      groupList:[]
    });
    const getLists = (page)=>{
      let params={
        page:page||state.current,
        type:'page',
        username: state.searchInfo.username,
        name: state.searchInfo.name,
        group_id: state.searchInfo.group_id
      }
      getUserList(params).then((result)=>{
        let resultData = result.Data
        state.userList = resultData.data

        state.total = resultData.total;
        state.current = parseInt(resultData.current_page);
        state.display = resultData.per_page;
      })
    }
    /**
     * 删除
     * @param id
     */
    const deleteUser =(id)=>{
      ElMessageBox.confirm('此操作将永久删除该账号吗, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        deleteUserData({id:id}).then(()=>{
          ElMessage({
            type: 'success',
            message: '删除成功!'
          });
          window.location.reload(true);
        })
      }).catch(() => {
        ElMessage({
          type: 'info',
          message: '已取消删除'
        });
      })
    }
    const pageChange =(p)=>{
      // 页码改变event ， p 为新的 current
      state.current = p;
      getLists();
    }

    const getGroupLists = ()=>{
        getGroupList().then((res)=>{
            state.groupList = res.Data;
        });
    }

    getLists(1)
    getGroupLists();
    return {
      ...toRefs(state),
      deleteUser,
      pageChange,
      getLists
    }
  },
  computed:{
    statusFilter(){
      return function (status){
        console.log(status)
        if(status>1){
          return '禁用'
        }else{
          return '正常'
        }
      }
    }
  }
};
</script>