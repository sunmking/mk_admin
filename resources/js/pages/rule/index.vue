<template>

  <div class="card-wrap">
    <div class="search-data">
      <div class="card-header">
        <span class="card-title">权限管理</span>
        <div class="right">
          <router-link :to="{path:'/rule/detail',query:{id:0}}">
            <el-button type="primary" size="small">添加</el-button>
          </router-link>
        </div>
      </div>
    </div>
    <div style="width: 100%;border-bottom: 10px solid #F4F4F4;"></div>
    <div class="card-body-blank">
        <el-table
            :data="ruleList"
            border
            header-row-class-name="table-header-th"
            size="small"
            height="500"
            :row-key="data=>data.id"
            :tree-props="{children: 'children'}">
          <el-table-column
              prop="id"
              width="100"
              align="left"
              label="编号">
          </el-table-column>
          <el-table-column
              label="权限" width="200" align="left">
            <template #default="scope" style="text-align:left">
              <span v-html="scope.row.title"></span>
            </template>
          </el-table-column>
          <el-table-column prop="depth" align="center" width="80" label="层级">
            <template #default="scope">
              <span v-if="scope.row.depth===1"><el-tag size="small" type="danger" effect="plain">一级</el-tag></span>
              <span v-if="scope.row.depth===2"><el-tag size="small" type="success" effect="plain">二级</el-tag></span>
              <span v-if="scope.row.depth===3"><el-tag size="small" type="info" effect="plain">三级</el-tag></span>
            </template>
          </el-table-column>
            <el-table-column prop="rule" width="260" align="center" label="规则"></el-table-column>
            <el-table-column prop="route" width="260" align="center" label="路由"></el-table-column>
          <el-table-column width="100" label="类型" align="center">
            <template #default="scope">
                <span v-if="scope.row.is_menu===1"><el-tag size="small" type="danger">菜单</el-tag></span>
                <span v-if="scope.row.is_menu===2"><el-tag size="small" type="warning">节点</el-tag></span>
                <span v-if="scope.row.is_menu===3"><el-tag size="small" type="success">接口</el-tag></span>
            </template>
          </el-table-column>
          <el-table-column prop="sort_id" width="100" align="center" label="排序">
          </el-table-column>
          <el-table-column label="操作" align="left" width="240" fixed="right">
            <template #default="scope">
              <router-link :to="{path:'/rule/detail',query:{id:scope.row.id}}">
                <el-button  size="small" class="mr-1">编辑</el-button>
              </router-link>
              <el-button
                  size="small"
                  @click="deleteRule(scope.row.id)">删除</el-button>
              <router-link :to="{path:'/rule/detail',query:{pid:scope.row.id,id:0}}" v-if="scope.row.depth!==3">
                <el-button type="info" size="small" class="ml-1">添加子权限</el-button>
              </router-link>
            </template>
          </el-table-column>

        </el-table>
    </div>
  </div>
</template>
<script>
import {reactive, toRefs} from "vue";
import {ElMessage, ElMessageBox} from "element-plus";
import {deleteRuleData, getRuleList} from "../../api/rule";

export default {
      setup(){
        const state = reactive({
          searchInfo: {
            title: ''
          },
          ruleList: [],
        });
        const getLists = ()=>{
          let params={
            type:'tree',
            title:state.searchInfo.title
          }
          getRuleList(params).then((result)=>{
            state.ruleList = result.Data;
          })
        }
        /**
         * 删除
         * @param id
         */
        const deleteRule =(id)=>{
            ElMessageBox.confirm('此操作将永久删除该权限吗, 是否继续?', '提示', {
              confirmButtonText: '确定',
              cancelButtonText: '取消',
              type: 'warning'
            }).then(() => {
              deleteRuleData({id:id}).then(()=>{
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
        getLists()
        return {
          ...toRefs(state),
          deleteRule,
          getLists
        }
      }
    };
</script>
