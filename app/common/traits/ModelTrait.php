<?php

namespace app\common\traits;

use think\facade\Db;

trait ModelTrait
{
    public function getAllTableFields(): array
    {
        return Db::getTableFields($this->table);
    }

    //模型读事件
    public static function onAfterRead($model)
    {
        if (isset($model->selectType) && $model->selectType) {
            foreach ($model->selectType as $key => $type) {
                $value = $model->getAttr($key);

                if ($value) {
                    $model->setAttr($key, transform($value, $type));
                }
            }
        }
    }
}
