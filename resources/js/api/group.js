import request from '../utils/request'

const Api = {
    // auth group
    GetList: 'auth/group-list',
    GetDetail: 'auth/group-info',
    SaveGroup: 'auth/save-group',
    SaveGroupRules: 'auth/save-group-rules',
    DeleteGroup: 'auth/delete-group',
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getGroupList(data) {
    return request({
        url: Api.GetList,
        method: 'GET',
        params:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getGroupDetail(data) {
    return request({
        url: Api.GetDetail,
        method: 'GET',
        params:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function saveGroupData(data) {
    return request({
        url: Api.SaveGroup,
        method: 'post',
        data:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function saveGroupRulesData(data) {
    return request({
        url: Api.SaveGroupRules,
        method: 'post',
        data:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function deleteGroupData(data) {
    return request({
        url: Api.DeleteGroup,
        method: 'post',
        data:data
    })
}