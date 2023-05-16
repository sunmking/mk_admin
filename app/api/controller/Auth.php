<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2021/7/9
 * Time: 13:38
 * Email: 1042080686@qq.com
 */

namespace app\api\controller;

use app\common\controller\BaseApi;
use app\common\service\AuthService;
use think\App;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\Response;

class Auth extends BaseApi
{
    protected $authService;

    public function __construct(AuthService $authService, App $app = null)
    {
        $this->authService = $authService;
        parent::__construct($app);
    }

    /**
     * 账号密码修改 API
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function changePass(): Response
    {
        $result = $this->authService->changePassword();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }

    /**
     * 账号列表
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException|Exception
     */
    public function getUserList(): Response
    {
        $userList = $this->authService->getAuthUserList();

        return json_ok(200, '请求成功', $userList);
    }

    /**
     * 获取账号信息
     *
     * @throws Exception
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getUserInfo(): Response
    {
        $type = $this->request->param('type', 'info');
        if ($type === 'info') {
            $result = $this->authService->getAuthUserInfo();
        } else {
            $result = $this->authService->getAuthUserDetail();
        }

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }

    /**
     * 获取账号信息
     */
    public function deleteUser(): Response
    {
        $result = $this->authService->deleteAuthUser();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }

    /**
     * 添加或编辑账号
     *
     * @throws Exception
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     */
    public function saveUser(): Response
    {
        $result = $this->authService->saveAuthUser();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }

    /**
     * 账号设置角色
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function saveUserGroup(): Response
    {
        $result = $this->authService->saveAuthUserGroup();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }

    /**
     * 角色保存
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function saveGroup(): Response
    {
        $result = $this->authService->editAuthGroup();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }

    /**
     * 角色授权
     */
    public function saveGroupRules(): Response
    {
        $result = $this->authService->saveGroupRules();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }

    /**
     * 获取角色列表*
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getGroupList(): Response
    {
        $list = $this->authService->getAuthGroupList();

        return json_ok(200, '', $list);
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getGroupInfo(): Response
    {
        $result = $this->authService->getAuthGroupInfo();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }

    /**
     * 删除角色
     *
     * @throws DbException
     */
    public function deleteGroup(): Response
    {
        $result = $this->authService->deleteAuthGroup();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getRuleList(): Response
    {
        $result = $this->authService->getAuthRuleList();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getGroupRuleIds(): Response
    {
        $result = $this->authService->getAuthGroupRuleIds();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function saveRule(): Response
    {
        $result = $this->authService->saveAuthRule();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getRuleInfo(): Response
    {
        $result = $this->authService->getAuthRuleInfo();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function deleteRule(): Response
    {
        $result = $this->authService->deleteAuthRule();

        return json_ok($result['Code'], $result['Msg'], $result['Data']);
    }
}
