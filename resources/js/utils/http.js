import axios from "axios";
import {ElMessage} from "element-plus";
// 创建axios实例
const httpService = axios.create({
    // 在请求地址前面加上baseURL
    //baseURL: import.meta.env.VITE_NODE_ENV,
    baseURL: '/apis/',
    // 当发送跨域请求时携带cookie
    // withCredentials: true,
    timeout: 10000,
});

// 请求拦截
httpService.interceptors.request.use(
    (config) => {
        return config;
    },
    (error) => {
        // 请求错误的统一处理
        return Promise.reject(error);
    }
);

// 响应拦截器
httpService.interceptors.response.use(
    /**
     * 通过判断状态码统一处理响应，根据情况修改
     * 同时也可以通过HTTP状态码判断请求结果
     */
    (response) => {
        const res = response.data;
        // 如果状态码不是200则认为有错误
        if (res.Code !== 200) {
            ElMessage({
                type:'error',
                message: res.Msg || "Error",
                duration: 1000,
            });
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
                    break
                case 404:
                    err.message = `请求地址出错: ${err.response.config.url}`
                    break
                case 408:
                    err.message = '请求超时'
                    break
                case 500:
                    err.message = '服务器内部错误'
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
export default httpService;
