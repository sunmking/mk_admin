<template>
  <div class="card-wrap" v-loading="body_loading">
    <div class="card-header">
      <span class="card-title">{{ruleForm.name}}-功能权限分配</span>
      <span class="right">
         <el-checkbox v-model="checkAll" :indeterminate="isIndeterminate" @change="handleCheckAllChange" class="mr-1">全选</el-checkbox>
         <el-button @click="saveAll" :disabled="isDisabled" size="small" class="add-data" plain>保存</el-button>
      </span>
    </div>
    <div class="card-body">
      <el-checkbox-group
          v-model="gRules"
          name="checkboxgroup"
          @change="handleCheckedRuleChange"
          style="width: 100%">
        <el-row v-for="item in ruleList" :key="item.id" :gutter="20" style="border-left: 1px dashed #b3b4b6;border-right: 1px dashed #b3b4b6;border-top: 1px dashed #b3b4b6">
          <el-col :span="3">
            <el-checkbox size="small" :key="item.id" :label="item.id" :disabled="gRules.indexOf(item.id) === -1 && groupInfo.pid>0">
              {{ item.title}}
             </el-checkbox>
           </el-col>

          <el-col :span="21" style="padding-left: 20px;border-left: 1px dashed #b3b4b6;">
            <el-row v-for="item_c in item.children" :key="item_c.id" :gutter="20">
              <el-col :span="4">
                <el-checkbox size="small" :key="item_c.id" :label="item_c.id"  :disabled="gRules.indexOf(item_c.id) === -1 && groupInfo.pid>0">
                  {{ item_c.title}}
                 </el-checkbox>
               </el-col>
              <el-col :span="20" style="padding-left: 20px;border-left: 1px dashed #b3b4b6;border-bottom: 1px dashed rgb(179, 180, 182);" v-if="item_c.children">
                <el-row :gutter="20">
                  <el-col :span="8" v-for="item_cc in item_c.children" :key="item_cc.id" style="padding: 5px;">
                    <el-checkbox :key="item_cc.id" :label="item_cc.id"  :disabled="gRules.indexOf(item_cc.id) === -1 && groupInfo.pid>0" size="small">
                      <span v-if="item_cc.is_menu==1">{{item_cc.title}}<el-tag size="small" type="info" effect="plain">菜单</el-tag></span>
                      <span v-if="item_cc.is_menu==2">{{item_cc.title}}<el-tag size="small" type="warning" effect="plain">节点</el-tag></span>
                      <span v-if="item_cc.is_menu==3">{{item_cc.title}}<el-tag size="small" type="success" effect="plain">接口</el-tag></span>
                     </el-checkbox>
                   </el-col>
                 </el-row>
               </el-col>
             </el-row>

           </el-col>
         </el-row>
      </el-checkbox-group>
    </div>
  </div>
</template>
<script>
import {reactive, ref, toRefs} from "vue";
import {ElMessage} from "element-plus";
import {useRoute, useRouter} from "vue-router";
import {getGroupDetail, saveGroupData, saveGroupRulesData} from "../../api/group";
import {getGroupRuleIds, getRuleList} from "../../api/rule";

export default {
  setup() {
    const router = useRouter();
    const route = useRoute();
    const state = reactive({
      ruleForm:{},
      body_loading:false,
      save_loading:false,
      isDisabled:false,
      checkAll: false,
      gRules: [],
      ruleList: [],
      isIndeterminate: true,
      groupInfo:{},
      allRuleIds:[]
    });

    // 获取角色信息
    const getGroupInfo = (id) => {
      getGroupDetail({id: id}).then((result) => {
        state.groupInfo = result.Data;
        state.ruleForm = result.Data;
      })
    }
    // 获取All权限信息
    const getAllRuleLists = ()=>{
      let params={
        type:'all',
      }
      getRuleList(params).then((result)=>{
        let ruleData = result.Data||[];
        ruleData.every(function (item){
            state.allRuleIds.push(item.id);
            return true;
        });
      })
    }
    // 获取权限信息
    const getRuleLists = ()=>{
      let params={
        type:'tree',
      }
      getRuleList(params).then((result)=>{
        state.ruleList = result.Data;
      })
    }
    // 获取角色权限信息
    const getGroupRuleListIds = (id)=>{
      let params={
        id:id,
      }
      getGroupRuleIds(params).then((result)=>{
       state.gRules = result.Data||[];
      })
    }
    const saveAll = () => {
        state.body_loading = true;
        state.save_loading = true;
        console.log(state.ruleForm)
        saveGroupRulesData({
          id:state.groupInfo.id,
          check_ids:state.gRules
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
              path:'/group/list'
            })
          });
        })
    }
    const handleCheckAllChange = (val) => {
      console.log(val)
      state.gRules = val ? state.allRuleIds : [];
      console.log(state.allRuleIds)
      console.log(state.gRules)
      state.isIndeterminate = false;
    };
    const handleCheckedRuleChange = (value) => {
      const checkedCount = value.length;
      state.checkAll = checkedCount === state.allRuleIds.length;
      state.isIndeterminate = checkedCount > 0 && checkedCount < state.allRuleIds.length;
    };
    getAllRuleLists()
    getGroupRuleListIds(route.query.id)
    getGroupInfo(route.query.id)
    getRuleLists()
    return {
      ...toRefs(state),
      handleCheckAllChange,
      handleCheckedRuleChange,
      saveAll
    }
  }
}
</script>