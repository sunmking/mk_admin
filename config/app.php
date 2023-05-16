<?php

// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
    // 应用地址
    'app_host' => env('app.host', ''),
    // 应用的命名空间
    'app_namespace' => '',
    // 是否启用路由
    'with_route' => true,
    // 开启应用快速访问
    'app_express' => true,
    // 默认应用
    'default_app' => 'backend',
    // 默认时区
    'default_timezone' => 'Asia/Shanghai',

    // 应用映射（自动多应用模式有效）
    'app_map' => [
        'apis' => 'api',
    ],
    // 域名绑定（自动多应用模式有效）
    'domain_bind' => [],
    // 禁止URL访问的应用列表（自动多应用模式有效）
    'deny_app_list' => ['common'],

    // 异常页面的模板文件
    'exception_tmpl' => \think\facade\App::getAppPath().'common/tpl/think_exception.tpl',

    'http_exception_template' => [
        // 定义404错误的重定向页面地址
        404 => \think\facade\App::getAppPath().'common/tpl/404.html',
        403 => \think\facade\App::getAppPath().'common/tpl/403.html',
        500 => \think\facade\App::getAppPath().'common/tpl/500.html',
    ],
    // 错误显示信息,非调试模式有效
    'error_message' => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg' => true,
];
