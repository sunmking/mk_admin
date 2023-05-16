<?php

use auth\InitTable;
use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;

class AddAuthRuleTable extends Migrator
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
        $table = $this->table(InitTable::TB_AUTH_RULE, ['engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '功能表', 'id' => 'id', 'primary_key' => ['id']]);
        $table->addColumn('pid', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '父菜单id'])
            ->addColumn('route', 'string', ['limit' => 256, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '菜单名称'])
            ->addColumn('icon', 'string', ['limit' => 128, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '图标'])
            ->addColumn('rule', 'string', ['limit' => 256, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '路径'])
            ->addColumn('title', 'string', ['limit' => 256, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '名称'])
            ->addColumn('is_menu', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '类型'])
            ->addColumn('highlight', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '高亮'])
            ->addColumn('sort_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '顺序'])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '状态'])
            ->addColumn('depth', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '深度'])
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '添加时间'])
            ->addIndex(['rule', 'pid'], ['unique' => true, 'name' => 'rpid'])
            ->create();
    }

    /**
     * down
     */
    public function down()
    {
        if ($this->table(InitTable::TB_AUTH_RULE)->exists()) {
            $this->table(InitTable::TB_AUTH_RULE)->drop();
        }
    }
}
