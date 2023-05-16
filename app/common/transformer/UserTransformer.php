<?php
/**
 * Created by PhpStorm.
 * User: mrk-sun
 * Date: 2018/8/13
 * Time: 15:10
 *
 * @author saviorlv <1042080686@qq.com>
 */

namespace app\common\transformer;

class UserTransformer extends Transformer
{
    public function transformer($item): array
    {
        return [
            'uid' => $item['id'],
            'username' => $item['username'],
            'name' => $item['name'],
            'mobile' => $item['mobile'],
            'email' => $item['email'],
            'sex' => $item['sex'],
            'department_id' => $item['department_id'],
            'department_name' => $item['department_name'],
            'position_id' => $item['position_id'],
            'position_name' => $item['position_name'],
            'group_id' => $item['group_id'],
            'group_name' => $item['group_name'],
        ];
    }
}
