<?php

declare(strict_types=1);

namespace app\common\model;

use app\common\traits\ModelTrait;
use think\db\exception\DbException;
use think\Model;
use think\Paginator;

/**
 * @mixin Model
 */
class BaseModel extends Model
{
    use ModelTrait;

    /**
     * @param  array  $params
     * @param  string  $fields
     * @param  int  $page_size
     * @param  string  $orderBy
     *
     * @throws DbException
     */
    public function getPageList($params = [], $fields = '', $page_size = 20, $orderBy = 'id DESC'): Paginator
    {
        if (!$fields) {
            $data = $this->where($params)->order($orderBy)->paginate($page_size);
        } else {
            $data = $this->where($params)->field($fields)->order($orderBy)->paginate($page_size);
        }

        return $data;
    }

    /**
     * @throws DbException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAllList($params = [], $fields = '', $orderBy = 'id DESC'): \think\Collection
    {
        if (!$fields) {
            $data = $this->where($params)->order($orderBy)->select();
        } else {
            $data = $this->where($params)->field($fields)->order($orderBy)->select();
        }

        return $data;
    }

    /**
     * @param  array  $params
     * @param  string  $fields
     * @return array|Model|null
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getInfo($params = [], $fields = '')
    {
        if (!$fields) {
            $data = $this->where($params)->find();
        } else {
            $data = $this->where($params)->field($fields)->find();
        }

        return $data ?: [];
    }

    /**
     * @return array|Model|null
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getById($id)
    {
        return $this->field('*')->where(['id' => $id])->find();
    }
}
