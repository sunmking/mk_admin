import request from '../utils/request'

const Api = {
    // auth group
    GetList: 'auth/rule-list',
    GetDetail: 'auth/rule-info',
    SaveRule: 'auth/save-rule',
    GroupRuleIds: 'auth/group-rule-ids',
    DeleteRule: 'auth/delete-rule',
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getRuleList(data) {
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
export function getRuleDetail(data) {
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
export function getGroupRuleIds(data) {
    return request({
        url: Api.GroupRuleIds,
        method: 'GET',
        params:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function saveRuleData(data) {
    return request({
        url: Api.SaveRule,
        method: 'post',
        data:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function deleteRuleData(data) {
    return request({
        url: Api.DeleteRule,
        method: 'post',
        data:data
    })
}