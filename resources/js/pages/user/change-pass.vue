<template>
  <div class="card-wrap" v-loading="body_loading">
    <div class="card-header">
      <span class="card-title">修改密码</span>
    </div>
    <div class="card-body">
      <el-row :gutter="10">
        <el-col :span="12">
          <el-form :model="ruleForm" :rules="rules" ref="ruleFormX" label-width="100px" size="small" class="demo-ruleForm">
            <el-form-item label="用户名" prop="username">
              <el-input v-model="ruleForm.username" disabled></el-input>
            </el-form-item>
            <el-form-item label="原始密码" prop="password">
              <el-input v-model="ruleForm.password" type="password"  style="display:none" auto-complete="false" :clearable="true"></el-input>
              <el-input v-model="ruleForm.password" type="password"  auto-complete="false" :clearable="true"></el-input>
            </el-form-item>

            <el-form-item label="新密码" prop="password1">
              <el-input v-model="ruleForm.password1" type="password" auto-complete="false" :clearable="true"></el-input>
            </el-form-item>

            <el-form-item label="确认密码" prop="password2">
              <el-input v-model="ruleForm.password2" type="password" auto-complete="false" :clearable="true"></el-input>
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
import {changeUserPass} from "../../api/user";
import storage from "store2";

export default {
  setup() {
    const ruleFormX = ref(null);
    const validatePass = function(rule, value, callback){
      if (value === '') {
        callback(new Error('请输入新密码'));
      } else {
        if (state.ruleForm.password1 !== '') {
          ruleFormX._value.validateField('password2');
        }
        callback();
      }
    };
    const validatePass2 = function(rule, value, callback){
      if (value === '') {
        callback(new Error('请再次输入密码'));
      } else if (value !== state.ruleForm.password1) {
        callback(new Error('两次输入密码不一致!'));
      } else {
        callback();
      }
    };
    const state = reactive({
      body_loading: false,
      isDisabled: false,
      show_invoice: false,
      form_loading:false,
      ruleForm: {
        uid:'',
        username: '',
        password:'',
        password1:'',
        password2:''
      },
      rules: {
        username: [
          { required: true, message: '请输入账号名称', trigger: 'blur' },
          { min: 2, max: 64, message: '长度在 2 到 64 个字符', trigger: 'blur' }
        ],
        password:[
          { required: true, message: '请输入原密码', trigger: 'blur' },
          { min: 6, max: 20, message: '长度在 6 到 20 个字符', trigger: 'blur' }
        ],
        password1:[
          { validator:validatePass, trigger: 'blur' },
          { min: 6, max: 20, message: '长度在 6 到 20 个字符', trigger: 'blur' }
        ],
        password2:[
          { validator:validatePass2,trigger: 'blur' },
          { min: 6, max: 20, message: '长度在 6 到 20 个字符', trigger: 'blur' }
        ],

      }
    });
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
          changeUserPass({...state.ruleForm}).then((res)=>{
            state.body_loading = false;
            state.save_loading = false;

            ElMessage({
              type: 'success',
              message: "密码修改成功！",
              duration: 1000,
            });
            setTimeout(function (){
              window.location.reload(true);
            },1000)
          })
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    }
    const userData = storage.get('userInfo')
    const intUser = ()=>{
      state.ruleForm ={
        uid:userData.id,
        username: userData.username,
        password:'',
        password1:'',
        password2:''
      }
    }
    intUser()
    return {
      ...toRefs(state),
      ruleFormX,
      resetForm,
      saveAll
    }
  }
}
</script>