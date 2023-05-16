<template>
  <div class="card-wrap" v-loading="body_loading">
    <div class="card-header">
      <span class="card-title" v-if="id>0">角色编辑</span>
      <span class="card-title" v-else>角色添加</span>
    </div>
    <div class="card-body">
      <el-row :gutter="10">
        <el-col :span="12">
          <el-form :model="ruleForm" :rules="rules" ref="ruleFormX" label-width="100px" size="small" class="demo-ruleForm">
            <el-form-item label="角色名称" prop="name">
              <el-input v-model="ruleForm.name" placeholder="角色名称"></el-input>
            </el-form-item>
            <el-form-item label="状态" prop="status">
              <el-radio-group v-model="ruleForm.status">
                <el-radio :label=1>启用</el-radio>
                <el-radio :label=2>禁用</el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="备注" prop="remark">
              <el-input type="textarea" v-model="ruleForm.remark" placeholder="备注"></el-input>
            </el-form-item>
            <el-form-item class="mt-1">
              <el-button size="small" type="primary" @click="saveAll" :disabled="isDisabled" v-loading="save_loading">提交</el-button>
              <el-button size="small" @click="resetForm">重置</el-button>
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
import {getGroupDetail, saveGroupData} from "../../api/group";

export default {
  setup() {
    const router = useRouter();
    const route = useRoute();
    const state = reactive({
      body_loading:false,
      save_loading:false,
      isDisabled:false,
      ruleForm: {
        id:'',
        name: '',
        status:1,
        remark:''
      },
      rules: {
        name:[
          { required: true, message: '请输入角色名称', trigger: 'blur' },
          { min: 2, max: 64, message: '长度在 2 到 64 个字符', trigger: 'blur' }
        ]
      },
      id:route.query.id,
      groupInfo:[]
    });
    // 获取角色信息
    const getGroupInfo = (id) => {
      getGroupDetail({id: id}).then((result) => {
        let resultData = result.Data;
        state.groupInfo = resultData;
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
          state.body_loading = true;
          state.save_loading = true;
          console.log(state.ruleForm)
          saveGroupData({...state.ruleForm}).then((res)=>{
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
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    }
    getGroupInfo(route.query.id)
    return {
      ...toRefs(state),
      ruleFormX,
      resetForm,
      saveAll
    }
  }
}
</script>