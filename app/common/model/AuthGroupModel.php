<?php
/**
 * Created by PhpStorm.
 * User: mrk-sun
 * Date: 2018/8/27
 * Time: 12:35
 *
 * @author saviorlv <1042080686@qq.com>
 */

namespace app\common\model;

use auth\InitTable;
use think\Collection;
use think\facade\Db;
use think\Paginator;

class AuthGroupModel extends BaseModel
{
    protected $autoWriteTimestamp = true;

    protected $createTime = 'create_time';

    protected $updateTime = 'update_time';

    protected $table = InitTable::TB_AUTH_GROUP;

    /**
     * @param  array  $params
     * @param  int  $page_size
     *
     * @throws \think\db\exception\DbException
     */
    public function getGroupPageList($params = [], $page_size = 20): Paginator
    {
        return Db::table(InitTable::TB_AUTH_GROUP)
            ->alias('gl')
            ->field('gl.*,group_concat(ar.title) as group_rules')
            ->leftJoin(InitTable::TB_AUTH_GROUP_ACCESS.' aga', 'aga.group_id=gl.id')
            ->leftJoin(InitTable::TB_AUTH_RULE.' ar', 'aga.rule_id=ar.id')
            ->whereOrRaw('ar.depth<3 OR ar.depth IS NULL')
            ->where($params)
            ->order('id DESC')
            ->group('gl.id')
            ->paginate($page_size);
    }

    /**
     * @param  array  $params
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getGroupAllList($params = []): Collection
    {
        return Db::table(InitTable::TB_AUTH_GROUP)
            ->alias('gl')
            ->field('gl.*,group_concat(ar.title) as group_rules')
            ->leftJoin(InitTable::TB_AUTH_GROUP_ACCESS.' aga', 'aga.group_id=gl.id')
            ->leftJoin(InitTable::TB_AUTH_RULE.' ar', 'aga.rule_id=ar.id')
            ->whereOrRaw('ar.depth<3 OR ar.depth IS NULL')
            ->where($params)
            ->order('id DESC')
            ->group('gl.id')
            ->select();
    }

    /**
     * @param  array  $params
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getGroupRule($params = []): Collection
    {
        return Db::table(InitTable::TB_AUTH_GROUP)->alias('ag')
            ->field('ag.name as group_name,aga.group_id,aga.rule_id')
            ->join(InitTable::TB_AUTH_GROUP_ACCESS.' aga', 'ag.id=aga.group_id')
            ->where($params)
            ->select();
    }

    /**
     * @param  array  $params
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getGroupRuleIds($params = []): array
    {
        return Db::table(InitTable::TB_AUTH_GROUP)->alias('ag')
            ->join(InitTable::TB_AUTH_GROUP_ACCESS.' aga', 'ag.id=aga.group_id')
            ->where($params)
            ->column('aga.rule_id');
    }
}
