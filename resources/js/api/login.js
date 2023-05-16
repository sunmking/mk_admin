import request from '../utils/request'

const Api = {
    Login: 'login/check',
    Logout: 'login/logout'
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function Login (data) {
    return request({
        url: Api.Login,
        method: 'POST',
        data:data
    })
}

export function Logout (data) {
    return request({
        url: Api.Logout,
        method: 'get',
        params:data,
        headers: {
            'Content-Type': 'application/json;charset=UTF-8'
        }
    })
}