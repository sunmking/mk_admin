<?php

use think\migration\Seeder;

class InitData extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $sql1 = "INSERT INTO `tb_auth_user` (`id`, `username`, `password_hash`, `name`, `salt`, `sex`, `work_number`, `img`, `desc`, `status`, `create_time`, `wechat`, `qq`, `email`, `mobile`, `school`, `address`, `skill`, `delete_time`, `update_time`) VALUES (1, 'admin', '76eb73a684c227bc7520bb3e7b6d6e43b1fc6bd6', '伊禾农品', '6560', 1, '', '', '', 1, 1608008396, '', '', '', '', '', '', '', 0, 0);";
        $this->execute($sql1);
        $sql2 = "INSERT INTO `tb_auth_group` (`id`, `name`, `status`, `remark`, `create_time`, `update_time`) VALUES (1, '超级管理员', 1, '管理员', 4294967295, 4294967295);";
        $this->execute($sql2);
        $sql = "INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (1, 0, 'Auth', 'rule', 'Auth', '权限管理', 1, 0, 10, 1, 1, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (2, 1, '#/user/list', '', '/user/list', '账号管理', 1, 3, 0, 1, 2, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (3, 1, '#/group/list', '', '/group/list', '角色管理', 1, 4, 0, 1, 2, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (4, 0, 'Home', 'home', 'Home', '工作台', 1, 0, 10000, 1, 1, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (5, 4, '#/home', '', '/home', '首页', 1, 10, 0, 1, 2, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (6, 16, '#/rule/detail', '', '/rule/detail', '功能详情', 2, 61, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (7, 2, 'api/Auth/getUserList', '', '/apis/auth/user-list', '账号列表', 2, 3, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (8, 2, 'api/Auth/getUserInfo', '', '/apis/auth/user-info', '账号详情', 2, 3, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (9, 2, 'api/Auth/saveUser', '', '/apis/auth/save-user', '账号保存', 2, 3, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (10, 2, 'api/Auth/deleteUser', '', '/apis/auth/delete-user', '账号删除', 2, 3, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (11, 3, 'api/Auth/editGroup', '', '/admin/auth/group-edit', '角色编辑', 2, 4, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (12, 3, 'api/Auth/getGroupList', '', '/apis/auth/group-list', '角色列表', 2, 4, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (13, 3, 'api/Auth/getGroupInfo', '', '/apis/auth/group-info', '角色详情', 2, 4, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (14, 3, 'api/Auth/saveGroup', '', '/apis/auth/save-group', '保存角色', 2, 4, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (15, 2, '#/user/detail', '', '/user/detail', '编辑用户', 2, 3, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (16, 1, '#/rule/list', '', '/rule/list', '功能列表', 1, 61, 0, 1, 2, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (17, 16, 'api/Auth/getRuleList', '', '/apis/auth/rule-list', '获取功能列表', 2, 61, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (18, 16, 'api/Auth/getRuleInfo', '', '/apis/auth/rule-info', '获取功能详情', 2, 0, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (19, 16, 'api/Auth/saveRule', '', '/apis/auth/save-rule', '保存功能信息', 2, 0, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (20, 16, 'api/Auth/deleteRule', '', '/apis/auth/delete-rule', '删除功能信息', 2, 0, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (21, 3, 'api/Auth/getGroupRuleIds', '', '/admin/auth/group-rule-ids', '获取角色列表', 2, 0, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (22, 3, 'api/Auth/deleteGroup', '', '/apis/auth/delete-group', '角色删除', 2, 4, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (23, 3, 'api/Auth/saveGroupRules', '', '/apis/auth/save-group-rules', '角色权限分配', 2, 4, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (24, 0, 'sys_manage', 'setting', 'sys_manage', '系统管理', 1, 0, 1, 1, 1, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (25, 24, '#/user/change-pass', '', '/user/change-pass', '修改密码', 1, 0, 0, 1, 2, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (26, 25, 'api/Auth/changePass', '', '/apis/auth/change-pass', '修改密码-API', 3, 0, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (27, 2, 'api/Auth/saveUserGroup', '', '/apis/auth/save-user-group', '设置角色', 2, 0, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (28, 2, 'api/User/getUserMenu', '', '/apis/user/menus', '刷新权限', 3, 0, 0, 1, 3, 0);
                INSERT INTO `tb_auth_rule` (`id`, `pid`, `route`, `icon`, `rule`, `title`, `is_menu`, `highlight`, `sort_id`, `status`, `depth`, `create_time`) VALUES (29, 2, '/#/user/group', '', '/user/group', '分配角色', 2, 2, 0, 1, 3, 0);
                ";
        $this->execute($sql);

        $sql3 = 'INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 1);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 2);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 3);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 4);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 5);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 6);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 7);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 8);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 9);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 10);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 11);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 12);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 13);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 14);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 15);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 16);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 17);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 18);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 19);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 20);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 21);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 22);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 23);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 24);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 25);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 26);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 27);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 28);
                INSERT INTO `tb_auth_group_access` (`group_id`, `rule_id`) VALUES (1, 29);
                ';
        $this->execute($sql3);

        $sql4 = 'INSERT INTO `tb_auth_user_group` (`group_id`, `uid`) VALUES (1, 1);';
        $this->execute($sql4);
    }
}
