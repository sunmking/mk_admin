import request from '../utils/request'

const Api = {
    GetUserList: 'common/user-list',
    GetProvinceList: 'common/province-list',
    GetCityList: 'common/city-list',
    GetAreaList: 'common/area-list',
    GetStreetList: 'common/street-list',
    GetColumnList: 'common/column-list',
    GetCargoList: 'common/cargo-list',
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getAllUserList(data) {
    return request({
        url: Api.GetUserList,
        method: 'GET',
        params:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getAllProvinceList(data) {
    return request({
        url: Api.GetProvinceList,
        method: 'GET',
        params:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getAllCityList(data) {
    return request({
        url: Api.GetCityList,
        method: 'GET',
        params:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getAllAreaList(data) {
    return request({
        url: Api.GetAreaList,
        method: 'GET',
        params:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getAllStreetList(data) {
    return request({
        url: Api.GetStreetList,
        method: 'GET',
        params:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getAllColumnList(data) {
    return request({
        url: Api.GetColumnList,
        method: 'GET',
        params:data
    })
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getAllCargoList(data) {
    return request({
        url: Api.GetCargoList,
        method: 'GET',
        params:data
    })
}