<?php

namespace app\common\transformer;

class UserDetailTransformer extends Transformer
{
    public function transformer($item): array
    {
        return [
            [
                'name' => 'ID', 'field' => 'uid', 'require' => true, 'option' => [], 'value' => isset($item['id']) ? $item['id'] : '', 'type' => 'hidden', 'hint' => '', 'state' => 'readonly',
            ],
            [
                'name' => '部门', 'field' => 'department_id', 'require' => true, 'option' => [], 'value' => isset($item['department_id']) ? $item['department_id'] : '', 'type' => 'hidden', 'hint' => '请输入', 'state' => 'readonly',
            ],
            [
                'name' => '职位', 'field' => 'position_id', 'require' => true, 'option' => [], 'value' => isset($item['position_id']) ? $item['position_id'] : '', 'type' => 'hidden', 'hint' => '请输入', 'state' => 'readonly',
            ],
            [
                'name' => '所属角色', 'field' => 'group_id', 'require' => true, 'option' => [], 'value' => isset($item['group_id']) ? $item['group_id'] : '', 'type' => 'hidden', 'hint' => '请输入', 'state' => 'readonly',
            ],
            [
                'name' => '账号名称', 'field' => 'username', 'require' => true, 'option' => [], 'value' => isset($item['username']) ? $item['username'] : '', 'type' => 'text', 'hint' => '请输入', 'state' => 'readonly',
            ],
            [
                'name' => '部门', 'field' => 'department_name', 'require' => true, 'option' => [], 'value' => isset($item['department_name']) ? $item['department_name'] : '', 'type' => 'text', 'hint' => '请输入', 'state' => 'readonly',
            ],
            [
                'name' => '职位', 'field' => 'position_name', 'require' => true, 'option' => [], 'value' => isset($item['position_name']) ? $item['position_name'] : '', 'type' => 'text', 'hint' => '请输入', 'state' => 'readonly',
            ],
            [
                'name' => '所属角色', 'field' => 'group_name', 'require' => true, 'option' => [], 'value' => isset($item['group_name']) ? $item['group_name'] : '', 'type' => 'text', 'hint' => '请输入', 'state' => 'readonly',
            ],
            [
                'name' => '姓名', 'field' => 'name', 'require' => true, 'option' => [], 'value' => isset($item['name']) ? $item['name'] : '', 'type' => 'text', 'hint' => '请输入', 'state' => 'editable',
            ],
            [
                'name' => '手机号', 'field' => 'mobile', 'require' => true, 'option' => [], 'value' => isset($item['mobile']) ? $item['mobile'] : '', 'type' => 'text', 'hint' => '请输入', 'state' => 'editable',
            ],
            [
                'name' => '邮箱', 'field' => 'email', 'require' => true, 'option' => [], 'value' => isset($item['email']) ? $item['email'] : '', 'type' => 'text', 'hint' => '请输入', 'state' => 'editable',
            ],
            [
                'name' => '性别', 'field' => 'sex', 'require' => true, 'option' => [['label' => '男', 'value' => 1], ['label' => '女', 'value' => 2]], 'value' => isset($item['sex']) ? $item['sex'] : '', 'type' => 'select', 'hint' => '请输入', 'state' => 'editable',
            ],
        ];
    }
}
