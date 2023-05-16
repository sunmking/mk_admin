<?php

use auth\InitTable;
use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\db\Column;
use think\migration\Migrator;

class AddAuthGroupTable extends Migrator
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
        $table = $this->table(InitTable::TB_AUTH_GROUP, ['engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '角色表', 'id' => 'id', 'primary_key' => ['id']]);
        $table->addColumn('name', 'string', ['limit' => 64, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '用户组名'])
            ->addColumn(Column::smallInteger('status')->setDefault(0)->setComment('状态'))
            ->addColumn(Column::string('remark')->setDefault('')->setComment('remark'))
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '添加时间'])
            ->addColumn('update_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => 'update时间'])
            ->create();
    }

    public function down()
    {
        if ($this->table(InitTable::TB_AUTH_GROUP)->exists()) {
            $this->table(InitTable::TB_AUTH_GROUP)->drop();
        }
    }
}
