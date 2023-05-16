<?php

declare(strict_types=1);

namespace app\common\validate;

use think\Validate;

class LoginCheckValidate extends Validate
{
    protected $rule = [
        'username|用户名' => 'require|max:50',
        'password|密码' => 'require|min:6|max:15',
    ];

    protected $message = [
        'username.require' => '用户名必须填写',
        'username.max' => '用户名称最多不能超过50个字符',
        'password.require' => '登陆密码必须填写',
        'password.min' => '登陆密码必须大于6个字符',
        'password.max' => '登陆密码不能超过15个字符',
    ];
}
