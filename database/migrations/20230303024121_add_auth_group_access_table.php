<?php

use auth\InitTable;
use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;

class AddAuthGroupAccessTable extends Migrator
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
        $table = $this->table(InitTable::TB_AUTH_GROUP_ACCESS, ['engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '用户组-功能关联表', 'id' => false]);
        $table->addColumn('group_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '用户组ID'])
            ->addColumn('rule_id', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '功能ID'])
            ->addIndex(['group_id', 'rule_id'], ['unique' => true, 'name' => 'ugid_funcid'])
            ->create();
    }

    public function down()
    {
        if ($this->table(InitTable::TB_AUTH_GROUP_ACCESS)->exists()) {
            $this->table(InitTable::TB_AUTH_GROUP_ACCESS)->drop();
        }
    }
}
