<?php

namespace app\common\model;

use auth\InitTable;
use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\facade\Db;
use think\model\concern\SoftDelete;
use think\Paginator;

class AuthUserModel extends BaseModel
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';

    protected $defaultSoftDelete = 0;

    protected $table = InitTable::TB_AUTH_USER;

    protected $autoWriteTimestamp = true;

    /**
     * @return array|\think\Model
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function getUserData($params)
    {
        $userData = Db::table(InitTable::TB_AUTH_USER)->alias('au')
            ->field('au.*')
            ->where($params)
            ->order('id', 'DESC')
            ->find();
        if (isset($userData) && $userData) {
            $userGroupIds = $this->getUserGroupIds([
                ['aug.uid', '=', $userData['id']],
            ]);
            $ug_ids = [];
            $userGroupIds && $ug_ids = array_column($userGroupIds, 'group_id');
            $userData['group_ids'] = $ug_ids;

            $userRules = Db::table(InitTable::TB_AUTH_USER_GROUP)
                ->alias('aug')
                ->join(InitTable::TB_AUTH_GROUP_ACCESS.' aga', 'aga.group_id=aug.group_id', 'left')
                ->field('aug.uid,aug.group_id,aga.rule_id')
                ->where([
                    ['aug.uid', '=', $userData['id']],
                ])->select()->toArray();

            $rules = '';
            $userRules && $rules = implode(',', array_column($userRules, 'rule_id'));
            $userData['rules'] = $rules;
        }

        return $userData ?: [];
    }

    /**
     * @return array|\think\Model|null
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getByUserName($username)
    {
        return $this->field('*')->where(['username' => $username])->find();
    }

    /**
     * 登录密码加密
     */
    public function encryptLoginPassword($loginPassword, $salt): string
    {
        return sha1(md5($loginPassword.$salt));
    }

    /**
     * @param  array  $params
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getUserGroups($params = []): array
    {
        return Db::table(InitTable::TB_AUTH_USER)
            ->field('aug.*')
            ->alias('au')
            ->leftJoin(InitTable::TB_AUTH_USER_GROUP.' aug', 'aug.uid=au.id')
            ->leftJoin(InitTable::TB_AUTH_GROUP.' ag', 'ag.id=aug.group_id')
            ->where($params)
            ->select()->toArray();
    }

    /**
     * @param  array  $params
     * @param  int  $page_size
     *
     * @throws Exception
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getPageUserList($params = [], $page_size = 20): Paginator
    {
        return Db::table(InitTable::TB_AUTH_USER)->alias('au')
            ->field('au.*, ag.name group_name, aug.group_id')
            ->join(InitTable::TB_AUTH_USER_GROUP.' aug', 'aug.uid=au.id', 'left')
            ->join(InitTable::TB_AUTH_GROUP.' ag', 'ag.id=aug.group_id', 'left')
            ->where($params)
            ->group('au.id')
            ->order('id', 'DESC')
            ->paginate($page_size)
            ->each(function (&$item_v) {
                $userGroupIds = $this->getUserGroupIds([
                    ['aug.uid', '=', $item_v['id']],
                ]);
                $ug_ids = [];
                $userGroupIds && $ug_ids = array_column($userGroupIds, 'group_id');
                $item_v['group_ids'] = $ug_ids;

                $userRules = Db::table(InitTable::TB_AUTH_USER_GROUP)
                    ->alias('aug')
                    ->leftJoin(InitTable::TB_AUTH_GROUP_ACCESS.' aga', 'aga.group_id=aug.group_id')
                    ->field('aug.uid,aug.group_id,aga.rule_id')
                    ->where([
                        ['aug.uid', '=', $item_v['id']],
                    ])->select()->toArray();

                $rules = '';
                $userRules && $rules = implode(',', array_column($userRules, 'rule_id'));
                $item_v['rules'] = $rules;

                return $item_v;
            });
    }

    /**
     * @throws Exception
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getAllUserList(array $params = []): Collection
    {
        return Db::table(InitTable::TB_AUTH_USER)->alias('au')
            ->field('au.*, ag.name group_name, aug.group_id')
            ->join(InitTable::TB_AUTH_USER_GROUP.' aug', 'aug.uid=au.id', 'left')
            ->join(InitTable::TB_AUTH_GROUP.' ag', 'ag.id=aug.group_id', 'left')
            ->where($params)
            ->group('au.id')
            ->order('au.id', 'DESC')
            ->select()
            ->each(function (&$item_v) {
                $userGroupIds = $this->getUserGroupIds([
                    ['aug.uid', '=', $item_v['id']],
                ]);
                $ug_ids = [];
                $userGroupIds && $ug_ids = array_column($userGroupIds, 'group_id');
                $item_v['group_ids'] = $ug_ids;

                $userRules = Db::table(InitTable::TB_AUTH_USER_GROUP)
                    ->alias('aug')
                    ->leftJoin(InitTable::TB_AUTH_GROUP_ACCESS.' aga', 'aga.group_id=aug.group_id')
                    ->field('aug.uid,aug.group_id,aga.rule_id')
                    ->where([
                        ['aug.uid', '=', $item_v['id']],
                    ])->select()->toArray();

                $rules = '';
                $userRules && $rules = implode(',', array_column($userRules, 'rule_id'));
                $item_v['rules'] = $rules;

                return $item_v;
            });
    }

    /**
     * @param  array  $params
     * @param  string  $field
     * @return array|\think\Model|null
     *
     * @throws Exception
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getUserInfo($params = [], $field = '*')
    {
        $user = $this->field($field)->where($params)->find();
        if ($user) {
            $userGroupIds = $this->getUserGroupIds([
                ['aug.uid', '=', $user['id']],
            ]);
            $ug_ids = [];
            $userGroupIds && $ug_ids = array_column($userGroupIds, 'group_id');
            $user['group_id'] = $ug_ids;
        }

        return $user;
    }

    /**
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function saveRuleUser(array $data = []): array
    {
        $id = isset($data['id']) ? intval($data['id']) : '';
        $result = [
            'success' => false,
            'code' => 3200,
            'data' => [],
            'msg' => '',
        ];
        isset($data['group_ids']) && $group_ids = $data['group_ids'];
        unset($data['group_ids']);
        self::startTrans();
        try {
            if (!$id) {
                $userInfo = self::getByUsername($data['username']);
                if (!empty($userInfo)) {
                    throw new \PDOException("账号：{$data['username']}已存在", 3202);
                }

                $salt = generate_salt(4);
                $data['password_hash'] = self::encryptLoginPassword($data['password_hash'], $salt);
                $data['salt'] = $salt;
                $id = self::insertGetId($data);
            } else {
                $user = self::getByID($id);
                $userInfo = self::getByUsername($data['username']);
                if (!empty($userInfo) && ($userInfo->id != $id)) {
                    throw new \PDOException("账号：{$data['username']}已存在", 3202);
                }

                if (isset($data['password_hash']) && !empty($data['password_hash'])) {
                    $data['password_hash'] = self::encryptLoginPassword($data['password_hash'], $user->salt);
                }

                $user->save($data);
            }
            if (isset($group_ids) && $group_ids) {
                $g_data = [];
                array_walk($group_ids, function ($item) use (&$g_data, $id) {
                    $g_data[] = [
                        'uid' => $id,
                        'group_id' => $item,
                    ];
                });
                if ($g_data) {
                    Db::table(InitTable::TB_AUTH_USER_GROUP)->where(['uid' => $id])->delete();
                    Db::table(InitTable::TB_AUTH_USER_GROUP)->insertAll($g_data);
                }
            }

            self::commit();

            $result['success'] = true;
            $result['code'] = 200;
            $result['msg'] = '操作成功';
            $result['data'] = [
                'userID' => $id,
            ];

            return $result;
        } catch (\PDOException $e) {
            self::rollback();

            $result['code'] = $e->getCode();
            $result['msg'] = $e->getMessage();

            return $result;
        }
    }

    /**
     * @throws DbException
     */
    public function saveUserGroup(array $data = []): array
    {
        $id = isset($data['id']) ? intval($data['id']) : '';
        $result = [
            'success' => false,
            'code' => 3200,
            'data' => [],
            'msg' => '',
        ];
        $group_ids = [];
        isset($data['group_ids']) && $group_ids = $data['group_ids'];
        unset($data['group_ids']);
        self::startTrans();
        try {
            $g_data = [];
            array_walk($group_ids, function ($item) use (&$g_data, $id) {
                $g_data[] = [
                    'uid' => $id,
                    'group_id' => $item,
                ];
            });

            Db::table(InitTable::TB_AUTH_USER_GROUP)->where(['uid' => $id])->delete();
            Db::table(InitTable::TB_AUTH_USER_GROUP)->insertAll($g_data);

            self::commit();

            $result['success'] = true;
            $result['code'] = 200;
            $result['msg'] = '操作成功';

            return $result;
        } catch (\PDOException $e) {
            self::rollback();

            $result['code'] = $e->getCode();
            $result['msg'] = $e->getMessage();

            return $result;
        }
    }

    /**
     * @param  array  $data
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function changePassword($data = []): array
    {
        $id = isset($data['id']) ? intval($data['id']) : '';
        $result = [
            'success' => false,
            'code' => '3200',
            'data' => [],
        ];
        try {
            self::startTrans();

            $user = self::getByID($id);

            if (isset($data['password_hash']) && !empty($data['password_hash'])) {
                $data['password_hash'] = self::encryptLoginPassword($data['password_hash'], $user->salt);
            }

            $user->save($data);
            self::commit();

            $result['success'] = true;
            $result['code'] = '0';
            $result['data'] = [
                'userID' => $id,
            ];

            return $result;
        } catch (\PDOException $e) {
            self::rollback();

            $result['code'] = $e->getCode();

            return $result;
        }
    }

    /**
     * @param  array  $params
     */
    public function getUserIds($params = []): array
    {
        return Db::table(InitTable::TB_AUTH_USER)->alias('au')
            ->leftJoin(InitTable::TB_AUTH_USER_GROUP.' aug', 'aug.uid=au.id')
            ->where($params)
            ->column('au.id');
    }

    /**
     * @param  array  $params
     * @return mixed
     *
     * @throws Exception
     */
    public function getUserGroupIds($params = [])
    {
        return Db::table(InitTable::TB_AUTH_USER_GROUP)
            ->alias('aug')
            ->leftJoin(InitTable::TB_AUTH_GROUP.' ag', 'ag.id=aug.group_id')
            ->field('aug.uid,aug.group_id,ag.name as group_name')
            ->where($params)
            ->select()->toArray();
    }

    /**
     * @param  array  $params
     * @param  null  $id
     * @return AuthUserModel|int|string
     */
    public function toSaveUser($params = [], $id = null)
    {
        if ($id !== null) {
            return $this->update($params, ['id' => $id]);
        } else {
            return $this->insert($params);
        }
    }

    /**
     * @throws DbException
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     *
     * @version v1
     *
     * @since 2021-7-9
     */
    public static function getUserGroupAccess(array $params = []): array
    {
        return Db::table(InitTable::TB_AUTH_RULE)->alias('ar')
            ->field('aga.rule_id,ar.*')
            ->leftJoin(InitTable::TB_AUTH_GROUP_ACCESS.' aga', 'aga.rule_id=ar.id')
            ->where($params)
            ->group('ar.id')
            ->order('sort_id DESC')
            ->select()->toArray();
    }

    /**
     * @throws DbException
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     *
     * @version v1
     *
     * @since 2021-7-9
     */
    public static function getUserGroupList(array $params = []): array
    {
        return Db::table(InitTable::TB_AUTH_USER_GROUP)->alias('aug')
            ->field('ag.name as group_name,ag.id,aug.uid')
            ->leftJoin(InitTable::TB_AUTH_GROUP.' ag', 'ag.id=aug.group_id')
            ->where($params)
            ->select()->toArray();
    }
}
