<template>
    <div class="card-wrap">
        <div class="card-header">
            <span class="card-title">角色管理</span>
        </div>
        <div class="card-body-blank">
            <el-table
                    :data="groupList"
                    fit
                    border
                    highlight-current-row
                    header-row-class-name="table-header-th"
                    size="small"
                    height="500" style="width: 100%">
                <el-table-column
                        width="60"
                        prop="id"
                        align="center"
                        label="编号">
                </el-table-column>
                <el-table-column
                        width="120"
                        align="center"
                        prop="name"
                        label="角色">
                </el-table-column>
                <el-table-column
                        prop="status"
                        align="center"
                        label="状态" width="100">
                    <template #default="scope">
                        <span>{{ statusFilter(scope.row.status) }}</span>
                    </template>
                </el-table-column>
                <el-table-column
                        align="center"
                        label="权限范围">
                    <template #default="scope">
                        <el-tooltip
                                placement="top"
                                width="200"
                                trigger="hover">
                            <template #content>
                                {{ scope.row.group_rules }}
                            </template>
                            <span>{{ stringSub(scope.row.group_rules, 48) }}</span>
                        </el-tooltip>
                    </template>
                </el-table-column>
                <el-table-column label="操作" width="200">
                    <template #default="scope">
                        <router-link class="mr-1" :to="{path:'/group/allot-rule',query:{id:scope.row.id}}">
                            <el-button size="small" plain>权限分配</el-button>
                        </router-link>
                        <auth-router-link :to="{path:'/group/detail',query:{id:scope.row.id}}" size="small" text="编辑"
                                          :route_name="'/group/detail'"></auth-router-link>
                    </template>
                </el-table-column>
            </el-table>
        </div>

        <div class="card-footer">
            <auth-router-link :to="{path:'/group/detail',query:{id:0}}" type="primary" size="small" text="新建"
                              :route_name="'/group/detail'"></auth-router-link>
            <div class="right">
                <el-pagination
                        small
                        background
                        @current-change="getLists"
                        :current-page.sync="current"
                        :page-size="display"
                        layout="prev, pager, next, jumper"
                        :total="total">
                </el-pagination>
            </div>
        </div>
    </div>
</template>
<script>
import {reactive, toRefs} from "vue";
import {ElMessage, ElMessageBox} from "element-plus";
import {deleteGroupData, getGroupList} from "../../api/group";
import AuthRouterLink from "../../components/AuthRouterLink";
import {stringSub} from "../../utils/util";

export default {
    methods: {stringSub},
    components: {AuthRouterLink},
    setup() {
        const state = reactive({
            total: 0,     // 记录总条数
            display: 20,   // 每页显示条数
            current: 1,     // 当前第n页 ， 也可以 watch current 的变化
            groupList: []
        });
        const getLists = (page) => {
            let params = {
                page: page || state.current,
                type: 'page',
            }
            getGroupList(params).then((result) => {
                let resultData = result.Data;
                state.groupList = resultData.data;
                state.total = resultData.total;
                state.current = parseInt(resultData.current_page);
                state.display = resultData.per_page;
            })
        }
        /**
         * 删除
         * @param id
         */
        const deleteGroup = (id) => {
            ElMessageBox.confirm('此操作将永久删除该角色吗, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                deleteGroupData({id: id}).then(() => {
                    ElMessage({
                        type: 'success',
                        message: '删除成功!'
                    });
                    window.location.reload(true);
                })
            }).catch(() => {
                ElMessage({
                    type: 'info',
                    message: '已取消删除'
                });
            })
        }
        getLists(1)
        return {
            ...toRefs(state),
            deleteGroup,
            getLists
        }
    },
    computed: {
        statusFilter() {
            return function (status) {
                console.log(status)
                if (status > 1) {
                    return '禁用'
                } else {
                    return '正常'
                }
            }
        }
    }
};
</script>