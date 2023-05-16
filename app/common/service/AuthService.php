<?php

namespace app\common\service;

use app\common\model\AuthGroupModel;
use app\common\model\AuthRuleModel;
use app\common\model\AuthUserModel;
use app\common\transformer\UserDetailTransformer;
use app\common\validate\LoginCheckValidate;
use auth\InitTable;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Db;
use think\Paginator;
use think\Request;
use utils\Data;
use utils\PHPTree;

class AuthService extends BaseService
{
    protected $request;

    protected $userModel;

    protected $groupModel;

    protected $ruleModel;

    public function __construct(
        Request $request,
        AuthUserModel $userModel,
        AuthGroupModel $groupModel,
        AuthRuleModel $ruleModel
    ) {
        $this->request = $request;
        $this->userModel = $userModel;
        $this->groupModel = $groupModel;
        $this->ruleModel = $ruleModel;
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function loginCheck(): array
    {
        $data = [
            'username' => $this->request->post('username'),
            'password' => $this->request->post('password'),
        ];
        $validate = new LoginCheckValidate();
        if ($validate->batch()->check($data) !== false) {
            $userInfo = $this->userModel->getByUserName($data['username']);
            if ($userInfo !== null) {
                if ($userInfo['status'] && ($userInfo['status'] == 1)) {
                    $pass = $this->userModel->encryptLoginPassword($data['password'], $userInfo['salt']);
                    if ($pass != $userInfo['password_hash']) {
                        return $this->returnMsg(400, '账户密码错误');
                    }
                    //rules
                    $user = $this->userModel->getInfo(['id' => $userInfo['id']]);
                    //expend
                    $data = $this->getUserExpend($user['id']);

                    if (200 === $data['Code']) {
                        $user['expend'] = $data['Data'];
                    } else {
                        $user['expend'] = [];
                    }
                    unset($user['salt'],$user['password_hash']);
                    $jwtClient = JwtAuthService::getInstance();

                    return $this->returnMsg(200, '登录成功', [
                        'userToken' => $jwtClient->create(['uid' => $user['id']]),
                        'userInfo' => $user,
                    ]);
                } else {
                    return $this->returnMsg(403, '该账户已被禁用，请联系管理员');
                }
            } else {
                return $this->returnMsg(1001, '该账户不存在');
            }
        } else {
            $msg = implode(',', $validate->getError());

            return $this->returnMsg(1000, $msg);
        }
    }

    /**
     * 用户详情
     *
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws \think\Exception
     */
    public function getUserDetail(): array
    {
        $id = $this->request->param('uid', 0, 'intval');
        if (!$id) {
            return $this->returnMsg('90121', '参数异常');
        }

        $res = $this->getAuthUserDetail($id);
        if ($res['Code'] == 0) {
            $transformer = new UserDetailTransformer();
            $res['Data'] = $transformer->transformer($res['Data']);
        }

        return $this->returnMsg($res['Code'], $res['Msg'], $res['Data']);
    }

    /**
     * 用户信息
     *
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws \think\Exception
     */
    public function getUserInfo(): array
    {
        $id = $this->request->param('uid', 0, 'intval');
        if (!$id) {
            return $this->returnMsg('90121', '参数异常');
        }

        $res = $this->getAuthUserDetail($id);

        return $this->returnMsg($res['Code'], $res['Msg'], $res['Data']);
    }

    /**
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws \think\Exception
     */
    public function saveUserInfo(): array
    {
        $userInfo = $this->request->param('user_detail', '');
        $uid = $this->request->param('uid', '');
        if (!$userInfo) {
            return $this->returnMsg(201901, '数据信息不全');
        }
        $user = [];
        $data = \json_decode($userInfo, true);

        $data && $user = array_column($data, 'value', 'field');

        if (!$user) {
            return $this->returnMsg('201902', '数据信息不全');
        }

        $res = $this->userModel->toSaveUser($user, $uid);

        if ($res != false) {
            $user_info = [];
            $res = $this->getAuthUserDetail($uid);
            if ($res['Code'] == 0) {
                $transformer = new UserDetailTransformer();
                $user_info = $transformer->transformer($res['Data']);
            }

            return $this->returnMsg(200, '保存成功', $user_info);
        } else {
            return $this->returnMsg('201903', '保存出错');
        }
    }

    /**
     * @return \think\Collection|Paginator
     *
     * @throws \think\Exception
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getAuthUserList()
    {
        $type = $this->request->param('type', 'page');
        $page_size = $this->request->param('page_size', 20);
        $username = $this->request->param('username');
        $name = $this->request->param('name');
        $group_id = $this->request->param('group_id');

        $params = [];
        $username && $params[] = ['au.username', 'like', "%{$username}%"];
        $name && $params[] = ['au.name', 'like', "%{$name}%"];
        $group_id && $params[] = ['aug.group_id', '=', $group_id];

        $params[] = ['au.delete_time', '=', 0];

        if ($type == 'page') {
            $list = $this->userModel->getPageUserList($params, $page_size);
        } else {
            $list = $this->userModel->getAllUserList($params);
        }

        return $list;
    }

    /**
     * @throws \think\Exception
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getAuthUserInfo(): array
    {
        $id = $this->request->param('id', 0);
        $map = [
            'id' => $id,
        ];
        $user = $this->userModel->getUserInfo($map);

        if ($user) {
            unset($user['create_time']);
            unset($user['update_time']);
            unset($user['password_hash']);
        } else {
            $user = [];
        }

        return $this->returnMsg(200, '请求成功', $user);
    }

    /**
     * @param  null  $id
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @throws \think\Exception
     */
    public function getAuthUserDetail($id = null): array
    {
        $d_id = $this->request->param('id', 0, 'int');
        !$id && $id = $d_id;
        if (!$id) {
            return $this->returnMsg(90121, '参数异常');
        }
        //rules
        $user = $this->userModel->getUserData(['au.id' => $id]);

        $user['rules'] = $user['rules'] ? explode(',', $user['rules']) : [];

        return $this->returnMsg(200, '网络请求成功', $user);
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function saveAuthUser(): array
    {
        $id = $this->request->param('id', 0, 'int');
        $username = $this->request->param('username', '');
        $password = $this->request->param('password_hash', '');
        $name = $this->request->param('name', '');
        $phone_mobile = $this->request->param('mobile', '');
        $email = $this->request->param('email', '');
        $sex = $this->request->param('sex', 1);
        $remark = $this->request->param('remark', '');
        $status = $this->request->param('status', 1);
        $group_ids = $this->request->param('group_ids/a', []);
        $data = [];

        if (!$id && !$password) {
            return $this->returnMsg(1006, '请填写登录密码');
        }

        $id && $data['id'] = $id;
        $username && $data['username'] = $username;
        $name && $data['name'] = $name;
        $password && $data['password_hash'] = $password;
        $email && $data['email'] = $email;
        $phone_mobile && $data['mobile'] = $phone_mobile;
        $sex && $data['sex'] = $sex;
        $remark && $data['remark'] = $remark;
        $status && $data['status'] = $status;
        $group_ids && $data['group_ids'] = $group_ids;

        $result = $this->userModel->saveRuleUser($data);
        if ($result['success'] === false) {
            return $this->returnMsg($result['code'], $result['msg']);
        }

        return $this->returnMsg(200, '操作成功');
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function saveAuthUserGroup(): array
    {
        $id = $this->request->param('id', 0, 'int');
        $group_ids = $this->request->param('group_ids/a', []);
        $data = [];

        if (!$id) {
            return $this->returnMsg(1006, '参数异常');
        }

        $data['id'] = $id;
        $data['group_ids'] = $group_ids;

        $result = $this->userModel->saveUserGroup($data);
        if ($result['success'] === false) {
            return $this->returnMsg($result['code'], $result['msg']);
        }

        return $this->returnMsg(200, '操作成功');
    }

    public function deleteAuthUser(): array
    {
        $id = $this->request->post('id', 0);
        if (!$id) {
            return $this->returnMsg(1001, '参数异常');
        }

        $result = $this->userModel->destroy($id);

        if ($result) {
            return $this->returnMsg(200, '删除成功');
        } else {
            return $this->returnMsg(1003, '删除失败');
        }
    }

    /**
     * @return array|\PDOStatement|string|\think\Collection|Paginator
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getAuthGroupList()
    {
        $page_size = $this->request->param('page_size', 20);
        $type = $this->request->param('type', 'all');
        $params = [];

        if ($type == 'all') {
            return $this->groupModel->getGroupAllList($params);
        } else {
            return $this->groupModel->getGroupPageList($params, $page_size);
        }
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getAuthGroupInfo(): array
    {
        $id = $this->request->param('id', 0);

        $info = $this->groupModel->getInfo(['id' => $id]);

        return $this->returnMsg(200, '请求成功', $info);
    }

    /**
     * 编辑用户组
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function editAuthGroup(): array
    {
        $id = $this->request->param('id');
        $name = $this->request->param('name');
        $remark = $this->request->param('remark');
        $status = $this->request->param('status', 1);

        $params = [];
        $params['name'] = $name;
        $params['remark'] = $remark;
        $params['status'] = $status;

        if (!$id) {
            $count = $this->groupModel->where(['name' => $params['name']])->count();
            if ($count > 0) {
                return $this->ReturnMsg(1001, '该用户组已添加，请修改后重试');
            }

            $params['status'] = 1;
            $params['create_time'] = time();
            $params['update_time'] = time();
            $result = $this->groupModel->insert($params);

            if ($result) {
                return $this->ReturnMsg(200, '添加成功');
            } else {
                return $this->ReturnMsg(1000, '添加失败');
            }
        } else {
            $info1 = $this->groupModel->getInfo(['id' => $id]);
            $info2 = $this->groupModel->getInfo(['name' => $params['name']]);
            if ($info2 && ($info2['id'] != $info1['id'])) {
                return $this->returnMsg('1001', '该用户组已添加，请修改后重试');
            }

            $params['update_time'] = time();
            $result = $this->groupModel->update($params, ['id' => $id]);

            if ($result) {
                return $this->returnMsg(200, '修改成功');
            } else {
                return $this->returnMsg(1001, '修改失败');
            }
        }
    }

    /**
     * 角色授权
     */
    public function saveGroupRules(): array
    {
        $id = $this->request->param('id');
        $check_ids = $this->request->param('check_ids/a');

        if (!$id || !$check_ids) {
            return $this->ReturnMsg(2000, '参数丢失，请稍候再试');
        }
        // 启动事务
        Db::startTrans();
        try {
            Db::table(InitTable::TB_AUTH_GROUP_ACCESS)->where(['group_id' => $id])->delete();
            $data = [];
            foreach ($check_ids as $key => $item) {
                $data[] = [
                    'group_id' => $id,
                    'rule_id' => $item,
                ];
            }
            Db::table(InitTable::TB_AUTH_GROUP_ACCESS)->insertAll($data);
            // 提交事务
            Db::commit();

            return $this->returnMsg(200, '操作成功');
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();

            return $this->returnMsg(1005, '操作失败');
        }
    }

    /**
     * 删除用户组
     *
     * @throws DbException
     */
    public function deleteAuthGroup(): array
    {
        $id = $this->request->param('id');
        if ($id == 1) {
            return $this->returnMsg(1003, '该角色不能被删除');
        }
        $map = [
            'id' => $id,
        ];
        $result = Db::table(InitTable::TB_AUTH_GROUP)->where($map)->delete();
        if ($result) {
            return $this->returnMsg(200, '删除成功');
        } else {
            return $this->returnMsg(1003, '删除失败');
        }
    }

    /**
     * 获取权限列表
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getAuthRuleList(): array
    {
        $type = $this->request->param('type', 'tree');
        $title = $this->request->param('title', '');
        $params = [];
        $title && $params[] = ['title', 'like', "{$title}%"];
        //所有权限
        $all = $this->ruleModel->getAllList($params, '*', 'sort_id DESC id DESC')->toArray();

        if ($type == 'tree') {
            $allRules = PHPTree::makeTree($all);
        } elseif ($type == 'all') {
            $allRules = $all;
        } else {
            $allRules = [];
            if (is_array($all) && count($all) > 0) {
                $allRules = Data::channelLevel($all, $pid = 0, $html = '&nbsp;', $fieldPri = 'id', $fieldPid = 'pid');
            }
        }

        return $this->returnMsg(200, '请求成功', array_values($allRules));
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getAuthRuleInfo(): array
    {
        $id = $this->request->param('id', 0);
        $map = [
            'id' => $id,
        ];
        $rule = $this->ruleModel->getInfo($map);

        return $this->returnMsg(200, '请求成功', $rule);
    }

    /**
     * 根据用户组查询权限id
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getAuthGroupRuleIds(): array
    {
        $groupRuleIds = [];
        $id = $this->request->param('id', 0);
        //角色权限
        $group_rule_ids = $this->groupModel->getGroupRuleIds(['aga.group_id' => $id]);
        if ($group_rule_ids) {
            $groupRuleIds = $group_rule_ids;
        }

        return $this->returnMsg(200, '请求成功', $groupRuleIds);
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function saveAuthRule(): array
    {
        $data = $this->request->post();
        $id = isset($data['id']) ? intval($data['id']) : 0;
        $pid = isset($data['pid']) ? intval($data['pid']) : 0;

        $data['status'] = 1;
        if ($pid == 0) {
            $data['depth'] = 1;
        } else {
            $p_rule = $this->ruleModel->getInfo(['id' => $pid]);
            $data['depth'] = $p_rule['depth'] + 1;
        }

        if (!$id) {
            $result = $this->ruleModel->insert($data);
        } else {
            $result = $this->ruleModel->update($data, ['id' => $id]);
        }
        if ($result) {
            return $this->returnMsg(200, '操作成功');
        } else {
            return $this->returnMsg(1003, '操作失败');
        }
    }

    /**
     * 权限删除
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function deleteAuthRule(): array
    {
        $id = $this->request->param('id');
        if (!$id) {
            return $this->returnMsg(1004, '网络请求异常');
        }
        $map = [
            'id' => $id,
        ];
        $model = $this->ruleModel->getInfo($map);
        if (!$model) {
            return $this->returnMsg(1005, '未查询到该权限信息');
        }
        if ($model->getAttr('pid') == 0) {
            return $this->returnMsg('1006', '请先删除子权限');
        }

        $result = $model->delete();
        if ($result) {
            return $this->returnMsg(200, '删除成功');
        } else {
            return $this->returnMsg(1003, '删除失败');
        }
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function changePassword(): array
    {
        $id = $this->request->param('uid', 0, 'int');
        $password = $this->request->param('password', '', 'trim');
        $password1 = $this->request->param('password1', '', 'trim');
        $password2 = $this->request->param('password2', '', 'trim');

        $data = [];
        if (!$id) {
            return $this->returnMsg(500, '参数异常');
        }
        if (!$password || !$password1 || !$password2) {
            return $this->returnMsg(1006, '请按要求填写');
        }
        $user = $this->userModel->getInfo(['id' => $id]);
        if (!$user) {
            return $this->returnMsg(404, '未查询到该用户信息');
        }
        $new_hash = $this->userModel->encryptLoginPassword($password, $user['salt']);
        if ($new_hash !== $user['password_hash']) {
            return $this->returnMsg(500, '原始密码不正确');
        }
        if ($password1 != $password2) {
            return $this->returnMsg(500, '两次密码输入不一致');
        }
        $data['id'] = $id;
        $password1 && $data['password_hash'] = $password1;

        $result = $this->userModel->changePassword($data);
        if ($result['success'] === false) {
            return $this->returnMsg($result['code']);
        }

        return $this->returnMsg(200, '操作成功');
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getUserAllDetail(): array
    {
        $uid = $this->request->param('user_id', '', 'int');

        if (!$uid) {
            return $this->returnMsg(1004, '请求异常');
        }
        cache('user:_id:'.$uid, null);
        //userInfo
        $user = $this->getUserData(['au.id' => $uid]);
        unset($user['salt'],$user['password_hash']);
        //expend
        $data = $this->getUserExpend($uid);

        if (200 === $data['Code']) {
            $user['expend'] = $data['Data'];
        } else {
            $user['expend'] = [];
        }

        return $this->returnMsg(200, '刷新成功', $user);
    }

    /**
     *  v1 获取用户基础信息.
     *
     * @return null|array|\think\Model
     *
     *@throws DbException
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     */
    public function getUserData(array $params = [])
    {
        return Db::table(InitTable::TB_AUTH_USER)->alias('au')
            ->field('au.*')
            ->where($params)
            ->order('id', 'DESC')
            ->find();
    }

    /**
     * v1 用户拓展权限.
     *
     * @param  null  $uid
     *
     * @throws DbException
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     */
    public function getUserExpend($uid = null): array
    {
        $data = [
            'groupIds' => [],
            'groupList' => [],
            'ruleList' => [],
            'menuList' => [],
            'ruleIds' => [],
        ];

        if (!$uid) {
            return $this->returnMsg(1000, '用户信息异常');
        }
        $user = $this->userModel->where(['id' => $uid])->find();

        // 角色
        $groupList = $this->userModel->getUserGroupList([
            ['aug.uid', '=', $uid],
        ]);
        $groupIds = [];
        $data['groupIds'] = [];

        if ($groupList) {
            $groupIds = array_unique(array_column($groupList, 'id'));
            $data['groupIds'] = $groupIds;
            $data['groupList'] = $groupList;
        }
        // 权限
        if ($groupIds) {
            $data['ruleList'] = $this->userModel->getUserGroupAccess([
                ['aga.group_id', 'in', $groupIds],
                ['ar.status', '=', 1],
            ]);

            isset($data['ruleList']) && $data['ruleIds'] = array_unique(array_column($data['ruleList'], 'id'));
        }

        //菜单
        ($data['ruleList']) && $data['menuList'] = PHPTree::makeTree($data['ruleList']);

        return $this->returnMsg(200, '操作成功', $data);
    }
}
