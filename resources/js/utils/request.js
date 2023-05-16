import axios from "axios";
import {ElMessage} from "element-plus";
import {getUserToken} from "../api/token";
import storage from "store2";
const user = JSON.parse(localStorage.getItem('userInfo'));
import Vrouter from "../router"
const router = Vrouter;
// 创建axios实例
const service = axios.create({
    // 在请求地址前面加上baseURL
    //baseURL: import.meta.env.VITE_NODE_ENV,
    baseURL: '/apis/',
    // 当发送跨域请求时携带cookie
    // withCredentials: true,
    timeout: 10000,
});

// 请求拦截
service.interceptors.request.use(
    (config) => {
        // 模拟指定请求令牌
        config.headers["X-Token"] = localStorage.getItem('user_token');
        return config;
    },
    (error) => {
        // 请求错误的统一处理
        console.log(error); // for debug
        return Promise.reject(error);
    }
);

// 响应拦截器
service.interceptors.response.use(
    /**
     * 通过判断状态码统一处理响应，根据情况修改
     * 同时也可以通过HTTP状态码判断请求结果
     */
    (response) => {
        const res = response.data;
        // 如果状态码不是200则认为有错误
        if (res.Code !== 200) {
            // 202101: 令牌过期; 202102: 签名不正确; 202103: 非法令牌;
            if (res.Code === 202101) {
                return getUserToken({uid:user.id}).then(res => {
                    // 刷新token成功，将最新的token更新到header中，同时保存在localStorage中
                    const { token } = res.Data;
                    localStorage.setItem('user_token',token);
                    // 获取当前失败的请求
                    const config = response.config
                    // 重置一下配置
                    config.headers['X-Token'] = token
                    config.baseURL = '/apis/' // url已经带上了/api，避免出现/api/api的情况
                    // 重试当前请求并返回promise
                    return service(config)
                }).catch(res => {
                    console.error('refreshtoken error =>', res)
                    //刷新token失败，神仙也救不了了，跳转到首页重新登录吧
                    storage.set('user_token','');
                    storage.set('isLogin','false');
                    storage.set('userInfo',{});
                    storage.set('menuInfo',{});
                    directLogin();
                })
            }else{
                ElMessage({
                    type:'error',
                    message: res.Msg || "Error",
                    duration: 1000,
                });
            }
            return Promise.reject(new Error(res.Msg || "Error"));
        } else {
            return res;
        }
    },
    (err) => {
        if(err && err.response.status){
            switch (err.response.status) {
                case 400:
                    err.message = '请求错误'
                    break
                case 401:
                    err.message = '未授权，请登录'
                    break
                case 403:
                    err.message = '暂无访问权限'
                    router.push({
                        path: '/403'
                    })
                    break
                case 404:
                    err.message = `请求地址出错: ${err.response.config.url}`
                    router.push({
                        path: '/404'
                    })
                    break
                case 408:
                    err.message = '请求超时'
                    break
                case 500:
                    err.message = '服务器内部错误'
                    router.push({
                        path: '/500'
                    })
                    break
                case 501:
                    err.message = '服务未实现'
                    break
                case 502:
                    err.message = '网关错误'
                    break
                case 503:
                    err.message = '服务不可用'
                    break
                case 504:
                    err.message = '网关超时'
                    break
                case 505:
                    err.message = 'HTTP版本不受支持'
                    break
                default:
            }
        }

        console.log("err" + err); // for debug
        ElMessage({
            type: 'error',
            message: err.message,
            duration: 1000,
        });
        return Promise.reject(err);
    }
);
/**
 * 登录跳转
 */
const  directLogin = ()=>{
    router.push({
        path: '/login',
        query: {
            redirectUrl: window.location.href.split('#')[1] || ''
        }
    })
}

export default service;
