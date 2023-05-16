<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2021/7/9
 * Time: 13:50
 * Email: 1042080686@qq.com
 */

namespace app\api\controller;

use app\common\controller\BaseApi;
use app\common\service\AuthService;
use think\App;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Response;
use think\response\Json;

class Login extends BaseApi
{
    protected $userService;

    public function __construct(AuthService $userService, App $app)
    {
        $this->userService = $userService;
        parent::__construct($app);
    }

    /**
     * v1
     *
     * @desc 用户登录
     *
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function loginCheck(): Response
    {
        $result = $this->userService->loginCheck();

        if (200 === $result['Code']) {
            return json_ok($result['Code'], $result['Msg'], $result['Data']);
        }

        return json_ok($result['Code'], $result['Msg']);
    }

    /**
     * v1 用户退出登录.
     */
    public function logout(): Json
    {
        $uid = $this->request->uid;
        cache('user:_id:'.$uid, null);

        return json_ok(200, '退出登录成功');
    }
}
