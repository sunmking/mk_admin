<template>
  <div class="card-wrap">
    <div class="card-header">
      <span class="card-title" v-show="parseInt(id)!==0">编辑权限</span>
      <span class="card-title" v-show="pid">添加子权限</span>
      <span class="card-title" v-show="parseInt(id)===0 && !pid">添加权限</span>
    </div>
    <div class="card-body">
      <el-row :gutter="10">
        <el-col :span="12">
          <el-form :model="ruleForm" :rules="rules" ref="ruleFormX" label-width="100px" size="small" class="demo-ruleForm">
            <el-form-item label="权限名称" prop="title">
              <el-input v-model="ruleForm.title" placeholder="权限名称"></el-input>
            </el-form-item>
            <el-form-item label="规则" prop="rule">
              <el-input v-model="ruleForm.rule" placeholder="规则"></el-input>
            </el-form-item>
            <el-form-item label="路由" prop="route">
              <el-input v-model="ruleForm.route" placeholder="路由"></el-input>
            </el-form-item>
            <el-form-item label="图标" prop="icon">
              <el-input v-model="ruleForm.icon" placeholder="icon 图标"></el-input>
            </el-form-item>
            <el-form-item label="高亮ID" prop="highlight">
              <el-input v-model="ruleForm.highlight" placeholder="高亮"></el-input>
            </el-form-item>
            <el-form-item label="排序" prop="sort_id">
              <el-input v-model="ruleForm.sort_id" placeholder="越大越靠前"></el-input>
            </el-form-item>
            <el-form-item label="类型" prop="is_menu">
              <el-select v-model="ruleForm.is_menu" placeholder="类型">
                <el-option
                    v-for="item in typeList"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="saveAll" :disabled="isDisabled">提交</el-button>
              <el-button @click="resetForm">重置</el-button>
            </el-form-item>
          </el-form>
        </el-col>
      </el-row>
    </div>
  </div>
</template>
<script>
import {reactive, ref, toRefs} from "vue";
import {ElMessage} from "element-plus";
import {useRoute, useRouter} from "vue-router";
import {getRuleDetail, saveRuleData} from "../../api/rule";

export default {
  setup() {
    const router = useRouter();
    const route = useRoute();
    const state = reactive({
      isDisabled:false,
      typeList: [{
        id: 1,
        name: '菜单'
      }, {
        id: 2,
        name: '节点'
      }, {
        id: 3,
        name: '接口'
      }, ],
      ruleForm: {
        id: '',
        title: '',
        route: '',
        rule: '',
        icon: '',
        is_menu: '',
        sort_id: 0,
        highlight: 0,
        pid: 0
      },
      rules: {
        title: [{
          required: true,
          message: '请输入权限名称',
          trigger: 'blur'
        }, {
          min: 2,
          max: 64,
          message: '长度在 3 到 64 个字符',
          trigger: 'blur'
        }],
        is_menu: [{
          required: true,
          message: '请选择类别',
          trigger: 'blur'
        }],
        rule: [{
          required: true,
          message: '填写规则',
          trigger: 'blur'
        }],
      },
      id: route.query.id,
      pid: route.query.pid,
      query: {},
      ruleInfo: [],
    });
    // 获取公司信息
    const getRuleInfo = (id) => {
      getRuleDetail({id: id}).then((result) => {
        let resultData = result.Data;
        state.ruleInfo = resultData;
        state.ruleForm = resultData;
      })
    }
    const ruleFormX = ref(null);
    const resetForm = ()=> {
      state.isDisabled=false;
      ruleFormX._value.resetFields();
    }
    const saveAll = () => {
      console.log(ruleFormX)
      ruleFormX._value.validate(function (valid) {
        if (valid) {
          if (state.pid) {
            state.ruleForm.pid = state.pid;
          }
          state.body_loading = true;
          state.save_loading = true;
          console.log(state.ruleForm)
          saveRuleData({...state.ruleForm}).then((res)=>{
            state.body_loading = false;
            state.save_loading = false;

            ElMessage({
              type: 'success',
              message: res.Msg,
              duration: 1000,
            });
            setTimeout(function (){
              router.push({
                path:'/rule/list'
              })
            });
          })
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    }
    getRuleInfo(route.query.id)
    return {
      ...toRefs(state),
      ruleFormX,
      resetForm,
      saveAll
    }
  }
}
</script>