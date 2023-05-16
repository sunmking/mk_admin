<?php

declare(strict_types=1);

namespace app\middleware;

use app\common\service\JwtAuthService;
use app\Request;
use auth\ApiCheckUtil;

class ApiCheck
{
    //不鉴权action 全小写
    protected $scopeAction = ['login/logincheck', 'login/logout', 'user/refreshtoken'];

    /**
     * 处理请求
     *
     * @return mixed|\think\response\Json
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function handle(Request $request, \Closure $next)
    {
        $controller = strtolower($request->controller());
        $action = strtolower($request->action());
        $token = $request->header('X-Token');
        !$token && $token = $request->param('user_token', '');
        $token = str_replace('"', '', $token);
        $action_rule = $controller.'/'.$action;

        $api_check = env('auth.api_check', false);
        $uid = 0;
        $user = [];
        if (!in_array($action_rule, $this->scopeAction, true)) {
            $jwtClient = JwtAuthService::getInstance();
            $data = $jwtClient->check($token);
            // token 验证
            if ($data['Code'] !== 200) {
                return json_ok($data['Code'], $data['Msg']);
            }
            $ext_data = $data['Data'];

            $uid = $ext_data['data']->uid;

            if ($api_check) {
                // 功能鉴权
                $checked = ApiCheckUtil::checkAuth($uid);

                if (!$checked) {
                    return json_ok(403, '该帐号暂无请求权限，请联系管理员', [], 403);
                }
            }
        }
        if ($uid) {
            if (!$user) {
                $user = ApiCheckUtil::getUserData(['id' => $uid]);
                cache('user:_id:'.$uid, $user, ['expire' => 2 * 24 * 60 * 60]);
            }
        }
        $request->user = $user;
        $request->uid = $uid;
        //
        return $next($request);
    }
}
