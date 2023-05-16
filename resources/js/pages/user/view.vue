<template>
  <div class="card-wrap" v-loading="body_loading">
    <div class="card-header">
      <span class="card-title">账号编辑</span>
    </div>
    <div class="card-body">
      <el-row :gutter="10">
        <el-col :span="12">
          <el-form :model="ruleForm" :rules="rules" class="demo-ruleForm" label-width="160px" ref="ruleFormX"
                   size="small">
            <el-form-item label="用户名" prop="username">
              <el-input v-model="ruleForm.username"></el-input>
            </el-form-item>
            <el-form-item label="登录密码" prop="password_hash">
              <el-input v-model="ruleForm.password_hash"></el-input>
            </el-form-item>
            <el-form-item label="姓名" prop="name">
              <el-input v-model="ruleForm.name"></el-input>
            </el-form-item>
            <el-form-item label="手机号" prop="mobile">
              <el-input v-model="ruleForm.mobile"></el-input>
            </el-form-item>
            <el-form-item label="邮箱" prop="email">
              <el-input v-model="ruleForm.email"></el-input>
            </el-form-item>
            <el-form-item label="性别" prop="sex">
              <el-radio-group v-model="ruleForm.sex">
                <el-radio :label=1>男</el-radio>
                <el-radio :label=2>女</el-radio>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="备注" prop="remark">
              <el-input type="textarea" v-model="ruleForm.remark"></el-input>
            </el-form-item>
            <el-form-item label="状态" prop="status">
              <el-radio-group v-model="ruleForm.status">
                <el-radio :label=1>启用</el-radio>
                <el-radio :label=2>禁用</el-radio>
              </el-radio-group>
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
import {getUserDetail, saveUserData} from "../../api/user";

export default {
  setup() {
    const router = useRouter();
    const route = useRoute();
    const checkPass = function(rule, value, callback){
      if(route.query.id===undefined || route.query.id==='0'){
        if (!value) {
          return callback(new Error('登陆密码不能为空'));
        }
        setTimeout(function(){
          if (value.length<6 || value.length>20) {
            callback(new Error('长度在 6 到 20 个字符'));
          } else {
            callback();
          }
        }, 1000);
      }else {
        callback();
      }
    };
    const state = reactive({
      isDisabled: false,
      show_invoice: false,
      is_show: false,
      ruleForm: {
        id: '',
        username: '',
        password_hash: '',
        name: '',
        mobile: '',
        email: '',
        sex: '',
        remark: '',
        status: 1,
      },
      rules: {
        username: [
          { required: true, message: '请输入账号名称', trigger: 'blur' },
          { min: 2, max: 64, message: '长度在 2 到 64 个字符', trigger: 'blur' }
        ],
        password_hash: [
          { validator: checkPass, trigger: 'blur' }
        ],
        name: [
          {required: true, message: '请输入姓名', trigger: 'blur'},
          {min: 2, max: 64, message: '长度在 2 到 64 个字符', trigger: 'blur'}
        ],

        sex: [
          {required: true, message: '请选择性别', trigger: 'change'}
        ],
      },
      id: route.query.id,
      query: {},
      userInfo: [],
    });
    // 获取账号详情
    const getUserInfo = (id)=>{
      getUserDetail({id:id}).then((res)=>{
        state.userInfo = res.Data
        state.ruleForm = res.Data
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
          saveUserData({...state.ruleForm}).then((res)=>{
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
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    }
    getUserInfo(route.query.id);
    return {
      ...toRefs(state),
      ruleFormX,
      resetForm,
      saveAll
    }
  }
}
</script>