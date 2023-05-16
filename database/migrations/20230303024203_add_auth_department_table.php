<?php

use auth\InitTable;
use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\Migrator;

class AddAuthDepartmentTable extends Migrator
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
        $table = $this->table(InitTable::TB_AUTH_DEPARTMENT, ['engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '部门表', 'id' => 'id', 'primary_key' => ['id']]);
        $table->addColumn('name', 'string', ['limit' => 64, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '部门名称'])
            ->addColumn('remark', 'string', ['limit' => 255, 'null' => false, 'default' => '', 'signed' => false, 'comment' => 'remark'])
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '添加时间'])
            ->create();
    }

    /**
     * down
     */
    public function down()
    {
        if ($this->table(InitTable::TB_AUTH_DEPARTMENT)->exists()) {
            $this->table(InitTable::TB_AUTH_DEPARTMENT)->drop();
        }
    }
}