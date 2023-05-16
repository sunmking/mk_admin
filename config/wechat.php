<?php

return [
    'mimi_program' => [
        'app_id' => 'wx6594aabb6c0b3cfa',
        'secret' => 'ffb3e2d10bc6cb060779f2b59c4403df',
        // 下面为可选项
        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',
        'log' => [
            'level' => 'debug',
            'file' => __DIR__.'/wechat.log',
        ],
    ],

];
