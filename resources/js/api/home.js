import request from '../utils/request'

const Api = {
    HomeStats: 'home/stats',
}

/**
 *
 * @param data
 * @returns {AxiosPromise}
 */
export function getHomeStats (data) {
    return request({
        url: Api.HomeStats,
        method: 'GET',
        params:data
    })
}

