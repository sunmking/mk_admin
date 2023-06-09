<?php

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    // 默认缓存驱动
    'default' => env('cache.driver', 'file'),

    // 缓存连接方式配置
    'stores' => [
        'file' => [
            // 驱动方式
            'type' => 'File',
            // 缓存保存目录
            'path' => '',
            // 缓存前缀
            'prefix' => '',
            // 缓存有效期 0表示永久缓存
            'expire' => 0,
            // 缓存标签前缀
            'tag_prefix' => 'tag:',
            // 序列化机制 例如 ['serialize', 'unserialize']
            'serialize' => [],
        ],
        // 更多的缓存连接
        // redis缓存
        'redis' => [
            // 驱动方式
            'type' => 'redis',
            // 服务地址
            'host' => '127.0.0.1',
            // 端口
            'port' => '6379',
            // 密码
            'password' => '',
            'select' => '4',
            // 全局缓存有效期（0为永久有效）
            'expire' => 0,
            // 缓存前缀
            'prefix' => 'sd:shop:',
            // 超时
            'timeout' => 0,
            'persistent' => false,
            'tag_prefix' => 'tag:',
            'serialize' => [],
        ],
    ],
];
