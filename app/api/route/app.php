<?php

use think\facade\Route;

Route::rule('transformer/:table/:simple', 'api/Debug/transformer');
Route::rule('output-json/:table', 'api/Debug/outPutJsonTable');

Route::group('/', function () {
    // login
    Route::rule('login/check', 'api/Login/loginCheck');
    Route::rule('login/logout', 'api/Login/logout');
    //账号
    Route::rule('auth/user-list', 'api/Auth/getUserList');
    Route::rule('auth/change-pass', 'api/Auth/changePass');
    Route::rule('auth/user-info', 'api/Auth/getUserInfo');
    Route::rule('auth/delete-user', 'api/Auth/deleteUser');
    Route::rule('auth/save-user', 'api/Auth/saveUser');
    Route::rule('auth/save-user-group', 'api/Auth/saveUserGroup');
    //角色
    Route::rule('auth/group-list', 'api/Auth/getGroupList');
    Route::rule('auth/group-info', 'api/Auth/getGroupInfo');
    Route::rule('auth/save-group', 'api/Auth/saveGroup');
    Route::rule('auth/save-group-rules', 'api/Auth/saveGroupRules');
    Route::rule('auth/delete-group', 'api/Auth/deleteGroup');
    //权限
    Route::rule('auth/rule-list', 'api/Auth/getRuleList');
    Route::rule('auth/rule-info', 'api/Auth/getRuleInfo');
    Route::rule('auth/save-rule', 'api/Auth/saveRule');
    Route::rule('auth/delete-rule', 'api/Auth/deleteRule');
    Route::rule('auth/group-rule-ids', 'api/Auth/getGroupRuleIds');
    // 用户相关权限
    Route::rule('user/menus', 'api/User/getUserMenu');
    Route::rule('user/refresh-token', 'api/User/refreshToken');
    // common function 不鉴权 无需添加权限
    Route::rule('common/user-list', 'api/Common/getAllUser');
    Route::rule('common/province-list', 'api/Common/getProvince');
    Route::rule('common/city-list', 'api/Common/getCity');
    Route::rule('common/area-list', 'api/Common/getArea');
    Route::rule('common/street-list', 'api/Common/getStreet');
    Route::rule('common/column-list', 'api/Common/getColumns');
    Route::rule('common/cargo-list', 'api/Common/getCargos');
    // 上传
    Route::rule('upload/single', 'api/Upload/uploadSingle');
    Route::rule('upload/multiple', 'api/Upload/uploadMultiple');
    Route::rule('upload/edit', 'api/Upload/uploadEdit');
    // setting
    Route::rule('setting/list', 'api/Setting/getList');
    Route::rule('setting/info', 'api/Setting/getDetail');
    Route::rule('setting/save', 'api/Setting/saveData');
    Route::rule('setting/save-other', 'api/Setting/saveOtherData');
    // post
    Route::rule('post/list', 'api/Post/getList');
    Route::rule('post/info', 'api/Post/getDetail');
    Route::rule('post/save', 'api/Post/saveInfo');
    // module
    Route::rule('module/list', 'api/Module/getList');
    Route::rule('module/info', 'api/Module/getDetail');
    Route::rule('module/save', 'api/Module/saveInfo');
    Route::rule('module/delete', 'api/Module/delete');
    // 统计
    Route::rule('state/index', 'api/State/index');

    //user

    //farmer
    Route::rule('farmer/list', 'api/Farmer/getList');
    Route::rule('farmer/detail', 'api/Farmer/getDetail');
    Route::rule('farmer/salesIntention', 'api/Farmer/salesIntentionList');
    Route::rule('farmer/export', 'api/Farmer/exportList');
    Route::rule('farmer/IntentionExport', 'api/Farmer/intentionExportList');

    // acquirer
    Route::rule('acquirer/list', 'api/Acquirer/getList');
    Route::rule('acquirer/detail', 'api/Acquirer/getDetail');
    Route::rule('acquirer/orderList', 'api/Acquirer/getAcquirerOrderList');
    Route::rule('acquirer/export', 'api/Acquirer/exportList');
    Route::rule('acquirer/OrderExport', 'api/Acquirer/OrderExportList');

    // acquisition
    Route::rule('acquisition/list', 'api/Acquisition/getList');
    Route::rule('acquisition/info', 'api/Acquisition/getDetail');
    Route::rule('acquisition/save', 'api/Acquisition/saveInfo');

    // classify
    Route::rule('classify/list', 'api/Category/getList');
    Route::rule('classify/info', 'api/Category/getDetail');
    Route::rule('classify/save', 'api/Category/saveInfo');
    //farmer_home
    Route::rule('notify/getInfo', 'api/Notify/getNotify');
    Route::rule('notify/save', 'api/Notify/saveNotify');

    // column
    Route::rule('column/list', 'api/Column/getList');
    Route::rule('column/info', 'api/Column/getDetail');
    Route::rule('column/save', 'api/Column/saveInfo');
});
