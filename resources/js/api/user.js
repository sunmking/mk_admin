import request from '../utils/request'

const Api = {
    UserMenus: 'user/menus',
    // auth user
    GetList: 'auth/user-list',
    GetDetail: 'auth/user-info',
    ChangePass: 'auth/change-pass',
    SaveUser: 'auth/save-user',
    DeleteUser: 'auth/delete-user',
    SaveUserGroup: 'auth/save-user-group',
}

/**
 * logout
 * @param data
 * @returns {AxiosPromise}
 * @constructor
 */
export function getUserMenus(data) {
    return request({
        url: Api.UserMenus,
        method: 'get',
        params:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getUserList(data) {
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
export function getUserDetail(data) {
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
export function saveUserData(data) {
    return request({
        url: Api.SaveUser,
        method: 'post',
        data:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function saveUserGroupData(data) {
    return request({
        url: Api.SaveUserGroup,
        method: 'post',
        data:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function deleteUserData(data) {
    return request({
        url: Api.DeleteUser,
        method: 'post',
        data:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function changeUserPass(data) {
    return request({
        url: Api.ChangePass,
        method: 'post',
        data:data
    })
}

