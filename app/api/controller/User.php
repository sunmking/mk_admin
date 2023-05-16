<?php

namespace app\api\controller;

use app\common\controller\BaseApi;
use app\common\service\AuthService;
use app\common\service\JwtAuthService;
use think\App;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\response\Json;

class User extends BaseApi
{
    protected $userService;

    public function __construct(AuthService $userService, App $app)
    {
        $this->userService = $userService;
        parent::__construct($app);
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getUserMenu(): Json
    {
        $res = $this->userService->getUserAllDetail();

        return json_ok($res['Code'], $res['Msg'], $res['Data']);
    }

    public function refreshToken(): Json
    {
        $uid = $this->request->param('uid');
        $jwtClient = JwtAuthService::getInstance();
        $token = $jwtClient->create(['uid' => $uid]);

        return json_ok(200, '刷新token成功', [
            'token' => $token,
        ]);
    }
}
