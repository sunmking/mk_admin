<?php

use auth\InitTable;
use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;

class AddAuthLoginLogTable extends Migrator
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
        $table = $this->table(InitTable::TB_AUTH_LOGIN_LOG, ['engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '权限系统-登录日志表', 'id' => 'id', 'primary_key' => ['id']]);
        $table->addColumn('uid', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => true, 'signed' => false, 'comment' => '用户id'])
            ->addColumn('ip', 'string', ['limit' => 32, 'null' => true, 'signed' => false, 'comment' => '登录ip'])
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '登录时间'])
            ->create();
    }

    public function down()
    {
        if ($this->table(InitTable::TB_AUTH_LOGIN_LOG)->exists()) {
            $this->table(InitTable::TB_AUTH_LOGIN_LOG)->drop();
        }
    }
}
