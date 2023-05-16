import request from '../utils/request'

const Api = {
    GetState: 'state/index',
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getStateIndex(data) {
    return request({
        url: Api.GetState,
        method: 'GET',
        params:data
    })
}