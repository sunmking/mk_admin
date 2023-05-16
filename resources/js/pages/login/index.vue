<template>
    <div class="login-warp">
        <div class="login-left" style='
        background-image: url("./images/login-bg@2x.png");
        display: flex;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        background-attachment:fixed;
        margin: 0;
        padding: 0;
        position: fixed;'>
            <el-image src="./images/login@2x.png" style="
                min-width: 480px;
                width: 40vw;
                height: auto" fit="contain"></el-image>
        </div>
        <div class="login-right">
            <div class="desc">
                东伊数字农业
            </div>
            <div class="main">
                <el-form :model="form" :rules="rules" @submit.native.prevent status-icon ref="ruleForm"
                         size="large"
                         class="user-layout-login" demo-ruleForm>
                    <el-form-item prop="username">
                        <el-input :prefix-icon="User" placeholder="账户" type="text" v-model="form.username"></el-input>
                    </el-form-item>
                    <el-form-item prop="password" style="margin-top: 32px;">
                        <el-input :prefix-icon="Unlock" placeholder="密码" type="password"
                                  v-model="form.password"></el-input>
                    </el-form-item>
                    <el-form-item style="margin-top:50px">
                        <el-button :loading="loginBtn" native-type="submit" @click="handleSubmit('ruleForm')"
                                   type="primary" class="login-button">登录
                        </el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>
    </div>
</template>

<script>
import {Login} from "../../api/login"
import {toRefs, reactive, ref} from 'vue'
import {ElMessage} from "element-plus";
import {useRouter} from "vue-router";
import storage from "store2";
import {Unlock, User} from "@element-plus/icons-vue";

export default {
    computed: {
        User() {
            return User
        },
        Unlock() {
            return Unlock
        }
    },
    setup() {
        const router = useRouter();//初始化路由
        const state = reactive({
            form: {
                username: '',
                password: '',
            },
            loginBtn: false,
            isLoginError: false,
        });
        //> ref同名属性,并使用ref(null)包装
        const ruleForm = ref(null);// 通过ref或reactive包裹起来让其成为响应式数据
        const rules = reactive({
            username: [
                {required: true, message: '请输入用户名', trigger: 'blur'}
            ],
            password: [
                {required: true, message: '请输入密码', trigger: 'blur'}
            ]
        });
        //2.一旦后面return {ruleForm},vue3会自动绑定ref="ruleForm"的组件
        //设定方法,但是要通过ruleForm.value才能拿到组件
        const handleSubmit = () => {
            //通过ref包裹的数据需要使用.value来取得相应的值,而reactive包裹的数据不需要通过.value来取得相应的值
            ruleForm.value.validate()
                .then(() => {
                    console.log('login')
                    state.loginBtn = true;
                    Login(state.form).then((res) => {
                        console.log(res)
                        if (res.Code !== 200) {
                            ElMessage({
                                type: 'warning',
                                message: res.Msg,
                                duration: 4000
                            })
                        } else {
                            let userInfo = res.Data.userInfo;
                            storage.set('isLogin', 'true');
                            storage.set('userInfo', userInfo);
                            storage.set('menuInfo', userInfo.expend);
                            storage.set('user_token', res.Data.userToken);
                            ElMessage({
                                type: 'success',
                                message: '登录成功',
                            })
                            state.isLoginError = false;

                            router.push({name: 'home'});//跳转页面
                        }
                    })
                        .catch(err => requestFailed(err))
                        .finally(() => {
                            state.loginBtn = false
                        })
                })
                .catch((error) => {
                    state.loginBtn = false
                    console.log("error", error);
                });
        }
        const requestFailed = (err) => {
            state.isLoginError = true;
            ElMessage({
                type: 'error',
                message: ((err.response || {}).data || {}).message || '请求出现错误，请稍后再试',
                duration: 4
            })
        }
        return {
            ...toRefs(state),
            ruleForm,
            handleSubmit,//提交
            rules
        };
    }
};

</script>

<style lang="less" scoped>
.login-warp {
  width: 100vw;
  min-width: 1000px;
  height: 100vh;
  display: flex;
  flex-flow: column wrap;
  justify-content: space-between;
  align-content: flex-end;
}

.login-left {
  display: flex;
  height: 100vh;
  min-width: 500px;
  width: 50vw;
  flex-flow: column wrap;
  justify-content: center;
  align-content: center;

}

.login-right {
  background-color: #fff;
  height: 100vh;
  min-width: 500px;
  width: 50vw;
  display: flex;
  flex-flow: column wrap;
  justify-content: center;
  align-content: center;
}

.desc {
  width: 360px;
  height: 37px;
  overflow-wrap: break-word;
  color: rgba(51, 51, 51, 1);
  font-size: 26px;
  letter-spacing: 3px;
  font-weight: 500;
  text-align: center;
  white-space: nowrap;
  line-height: 37px;
  margin-bottom: 50px;
}

.main {
  width: 360px;
}

button.login-button {
  padding: 0 15px;
  font-size: 21px;
  font-weight: 400;
  color: #FFFFFF !important;
  --el-button-size: 48px;
  height: var(--el-button-size)!important;
  line-height: 24px !important;
  width: 100%;
}
</style>
