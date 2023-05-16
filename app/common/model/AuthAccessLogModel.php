<?php
/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2018/12/5
 * Time: 14:09
 * Email: 1042080686@qq.com
 */

namespace app\common\model;

use auth\InitTable;

class AuthAccessLogModel extends BaseModel
{
    protected $table = InitTable::TB_AUTH_ACCESS_LOG;
}
