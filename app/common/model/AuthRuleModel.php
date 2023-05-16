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
use think\facade\Db;

class AuthRuleModel extends BaseModel
{
    protected $table = InitTable::TB_AUTH_RULE;

    /**
     * @param  array  $params
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\DbException
     */
    public function getGroupRule($params = []): array
    {
        $subQuery = Db::table(InitTable::TB_AUTH_GROUP)
            ->alias('hag')
            ->join(InitTable::TB_AUTH_GROUP_ACCESS.' haga', 'haga.group_id=hag.id', 'LEFT')
            ->where($params)->field('haga.rule_id')->select()->toArray();

        $data['status'] = 1;

        $subQuery && $data['id'] = array_unique(array_column($subQuery, 'rule_id'));

        return self::where($data)->order('sort_id DESC, id ASC')->select()->toArray();
    }
}
