<?php
/**
 * Created by PhpStorm.
 * User: mrk-sun
 * Date: 2018/8/27
 * Time: 14:52
 *
 * @author saviorlv <1042080686@qq.com>
 */

namespace app\common\model;

use auth\InitTable;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Db;
use think\Model;

class AuthGroupAccessModel extends Model
{
    protected $table = InitTable::TB_AUTH_GROUP_ACCESS;

    /**
     * @return array|mixed
     *
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getUserGroupAccessInfo(array $params)
    {
        return Db::table(InitTable::TB_AUTH_GROUP_ACCESS)->alias('aga')
            ->field('ag.*,aga.uid')
            ->leftJoin('tb_auth_group ag', 'ag.id=aga.group_id')
            ->where($params)
            ->find();
    }
}
