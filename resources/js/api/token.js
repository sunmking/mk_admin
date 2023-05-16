import request from '../utils/request'

const Api = {
    RefreshToken: 'user/refresh-token',
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getUserToken (data) {
    return request({
        url: Api.RefreshToken,
        method: 'GET',
        params:data
    })
}

