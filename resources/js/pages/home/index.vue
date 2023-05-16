<template>
    <div class="card-wrap card-index">
        <div class="item-list" style="box-shadow: none;margin:auto;height: 40px;line-height:40px;padding-left: 10px">
            <span>你好：{{ userInfo ? userInfo.username : '' }}，今天是{{datetime()}}。</span>
        </div>
    </div>
    <div class="card-wrap card-index">
        <div class="item-list">
            <el-row class="item-top">
                <el-icon class="top-icon">
                    <office-building/>
                </el-icon>
                服务器信息
            </el-row>
            <el-row class="item-row">
                <el-col :span="24">
                    <div class="sc_warp" id="system_warp" style="display: block;padding-bottom: 20px;">
                        <table cellpadding="0" cellspacing="0" class="system_table">
                            <tbody>
                            <tr>
                                <td class="gray_bg">服务器系统：</td>
                                <td>{{ sys_info.os }}</td>
                                <td class="gray_bg">网站域名/IP：</td>
                                <td>{{ sys_info.domain }} [ {{ sys_info.ip }} ]</td>
                            </tr>
                            <tr>
                                <td class="gray_bg">服务器环境：</td>
                                <td style="line-height: 28px;padding-right: 20px;">{{ sys_info.web_server }}</td>
                                <td class="gray_bg">PHP 版本：</td>
                                <td>{{ sys_info.phpv }}</td>
                            </tr>
                            <tr>
                                <td class="gray_bg">Mysql 版本：</td>
                                <td>{{ sys_info.mysql_version }}</td>
                                <td class="gray_bg">GD 版本：</td>
                                <td>{{ sys_info.gdinfo }}</td>
                            </tr>
                            <tr>
                                <td class="gray_bg">文件上传限制：</td>
                                <td>{{ sys_info.fileupload }}</td>
                                <td class="gray_bg">最大占用内存：</td>
                                <td>{{ sys_info.memory_limit }}</td>
                            </tr>
                            <tr>
                                <td class="gray_bg">POST限制：</td>
                                <td>{{ sys_info.postsize ? sys_info.postsize : 'unknown' }}</td>
                                <td class="gray_bg">最大执行时间：</td>
                                <td>{{ sys_info.max_ex_time }}</td>
                            </tr>
                            <tr>
                                <td class="gray_bg">Zip支持：</td>
                                <td>{{ sys_info.zip }}</td>
                                <td class="gray_bg">Zlib支持：</td>
                                <td>{{ sys_info.zlib }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </el-col>
            </el-row>
        </div>
    </div>
</template>
<script>
import {reactive, toRefs} from "vue";
import {getStateIndex} from "../../api/state";
import {Histogram, OfficeBuilding} from "@element-plus/icons-vue";
import storage from "store2";
import {datetime} from "../../utils/util";

export default {
    name: 'index',
    methods: {datetime},
    components: {Histogram, OfficeBuilding},
    setup() {
        const state = reactive({
            userInfo: storage.get('userInfo') || {},
            state_data: [],
            sys_info: [],
        });
        const getStateData = () => {
            getStateIndex({}).then((res) => {
                state.state_data = res.Data.state_data;
                state.sys_info = res.Data.sys_data;
            })
        }
        getStateData();
        return {
            ...toRefs(state),
        }
    }
};
</script>
<style>
.card-index {
    height: auto;
    margin-top: 14px;
}

.sc_warp {
    display: none;
    overflow: hidden;
    width: 96%;
    margin: 20px auto;
}

.system_table {
    border: 1px solid #eee;
    width: 100%;
}

.system_table td.gray_bg {
    background: #f9f9f9;
    width: 15%;
}

.system_table td {
    height: 40px;
    line-height: 40px;
    font-size: 12px;
    color: #454545;
    border-bottom: 1px solid #eee;
    border-right: 1px solid #eee;
    width: 35%;
    padding-left: 3%;
}

.top-icon {
    line-height: 25px;
    margin-right: 14px;
    font-size: 24px;
}

.item-list {
    display: block;
    box-shadow: 2px 5px 5px #e9e9e9;
    margin: 14px auto;
}

.item-top {
    padding: 24px 20px 0;
}
</style>
