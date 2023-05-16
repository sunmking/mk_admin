import {createRouter, createWebHashHistory, useRoute} from 'vue-router';
import storage from "store2";
// 基于 Vue 异步组件 + Webpack 实现路由懒加载
function loadView(dir, view) {
    // 注释不要去掉，对应上面 webpack 编译后的文件名
    return () => import(/* webpackChunkName: "[request]" */ '../' + dir + '/' + view + '.vue');
}

const sys_title = "-山东数字农业管理系统";
const routes = [
    {
        name: 'notFound',
        path: '/:path(.*)+',
        meta: {
            name:'notFound',
            layout:'main',
            title: '404',
        },
        redirect: {
            name: 'home',
        }
    },
    {
        name: '403',
        path: '/403',
        component: loadView('pages/exception','403'),
        meta: {
            title: '无权限'+sys_title,
            layout:'main'
        },
    },{
        name: '404',
        path: '/404',
        component: loadView('pages/exception','404'),
        meta: {
            title: '不存在'+sys_title,
            layout:'main'
        },
    },{
        name: '500',
        path: '/500',
        component: loadView('pages/exception','500'),
        meta: {
            title: '服务器异常'+sys_title,
            layout:'main'
        },
    },
    {
        name: 'home',
        path: '/home',
        component: loadView('pages/home','index'),
        meta: {
            name:'/home',
            title: '首页'+sys_title,
            layout:'main'
        },
    },
    {
        name: 'login',
        path: '/login',
        component: loadView('pages/login','index'),
        meta: {
            name:'/login',
            title: '登录'+sys_title,
            layout:'default'
        },
    },
    // 账号管理
    {
        name: 'user-list',
        path: '/user/list',
        component: loadView('pages/user','index'),
        meta: {
            name: '/user/list',
            title: '账号列表'+sys_title,
            layout:'main'
        },
    },
    {
        name: 'user-detail',
        path: '/user/detail',
        component: loadView('pages/user','view'),
        meta: {
            name: '/user/list',
            title: '账号详情'+sys_title,
            layout:'main'
        },
    },
    {
        name: 'user-group',
        path: '/user/group',
        component: loadView('pages/user','group'),
        meta: {
            name: '/user/list',
            title: '账号授权'+sys_title,
            layout:'main'
        },
    },
    {
        name: 'user-change-pass',
        path: '/user/change-pass',
        component: loadView('pages/user','change-pass'),
        meta: {
            name: '/user/change-pass',
            title: '修改密码'+sys_title,
            layout:'main'
        },
    },
    // 角色管理
    {
        name: 'group-list',
        path: '/group/list',
        component: loadView('pages/group','index'),
        meta: {
            name: '/group/list',
            title: '角色列表'+sys_title,
            layout:'main'
        },
    },
    {
        name: 'group-detail',
        path: '/group/detail',
        component: loadView('pages/group','view'),
        meta: {
            name: '/group/list',
            title: '角色详情'+sys_title,
            layout:'main'
        },
    },
    {
        name: 'group-allot-rule',
        path: '/group/allot-rule',
        component: loadView('pages/group','allot-rule'),
        meta: {
            name: '/group/allot-rule',
            title: '角色授权'+sys_title,
            layout:'main'
        },
    },
    // 功能管理
    {
        name: 'rule-list',
        path: '/rule/list',
        component: loadView('pages/rule','index'),
        meta: {
            name: '/rule/list',
            title: '功能列表'+sys_title,
            layout:'main'
        },
    },
    {
        name: 'rule-detail',
        path: '/rule/detail',
        component: loadView('pages/rule','view'),
        meta: {
            name: '/rule/list',
            title: '功能详情'+sys_title,
            layout:'main'
        },
    }
];

const router = createRouter({
    routes,
    history: createWebHashHistory(),
});

router.beforeEach((to, from, next) => {
    const title = to.meta && to.meta.title;
    const isLogin = storage.get('isLogin')

    if (title) {
        document.title = title;
    }
    let path = to.path;
    if (!isLogin && path !=='/login') {
        next({
            path:"/login"
        });
    } else {
        next();
    }
});

// eslint-disable-next-line no-unused-vars
router.afterEach((to,from,next) => {
    window.scrollTo(0,0);
});

export default router;
