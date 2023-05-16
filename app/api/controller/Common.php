<?php

namespace app\api\controller;

use app\BaseController;
use app\common\model\AuthUserModel;
use think\response\Json;

class Common extends BaseController
{
    public function getAllUser(): Json
    {
        $list = app()->make(AuthUserModel::class)->getAllList();

        return json_ok(200, '请求成功', $list);
    }
}
