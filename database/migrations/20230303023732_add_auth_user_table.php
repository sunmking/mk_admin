<?php

use auth\InitTable;
use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\db\Column;
use think\migration\Migrator;

class AddAuthUserTable extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $table = $this->table(InitTable::TB_AUTH_USER, ['engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '账号表', 'id' => 'id', 'primary_key' => ['id']]);
        $table->addColumn('username', 'string', ['limit' => 32, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '用户名'])
            ->addColumn('password_hash', 'string', ['limit' => 64, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '密码'])
            ->addColumn('name', 'string', ['limit' => 32, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '姓名'])
            ->addColumn('salt', 'string', ['limit' => 4, 'null' => false, 'default' => null, 'signed' => false, 'comment' => 'salt'])
            ->addColumn('sex', 'boolean', ['null' => false, 'default' => 1, 'signed' => false, 'comment' => '性别1男2女'])
            ->addColumn('department_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '部门id'])
            ->addColumn('position_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '岗位id'])
            ->addColumn('work_number', 'string', ['limit' => 16, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '工号'])
            ->addColumn('img', 'string', ['limit' => 128, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '照片'])
            ->addColumn('desc', 'string', ['limit' => 1024, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '员工介绍'])
            ->addColumn('status', 'boolean', ['null' => false, 'default' => 1, 'signed' => false, 'comment' => '状态1正常-1删除'])
            ->addColumn('wechat', 'string', ['limit' => 32, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '微信号'])
            ->addColumn('qq', 'string', ['limit' => 16, 'null' => false, 'default' => '', 'signed' => false, 'comment' => 'QQ号'])
            ->addColumn('email', 'string', ['limit' => 64, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '邮箱'])
            ->addColumn('mobile', 'string', ['limit' => 12, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '手机'])
            ->addColumn('school', 'string', ['limit' => 128, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '毕业学校'])
            ->addColumn('address', 'string', ['limit' => 128, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '地址'])
            ->addColumn('skill', 'string', ['limit' => 256, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '技能'])
            ->addColumn(Column::integer('company_id')->setDefault(0)->setComment('所属公司'))
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '添加时间'])
            ->addColumn('delete_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '删除时间'])
            ->addColumn('update_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '更新时间'])
            ->addIndex(['username'], ['unique' => true, 'name' => 'username'])
            ->create();
    }

    /**
     * @return void
     */
    public function down()
    {
        if ($this->table(InitTable::TB_AUTH_USER)->exists()) {
            $this->table(InitTable::TB_AUTH_USER)->drop();
        }
    }
}
