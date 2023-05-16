<?php

use auth\InitTable;
use think\migration\db\Column;
use think\migration\Migrator;

class AddAuthUserCompanyTable extends Migrator
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
        $table = $this->table(InitTable::TB_AUTH_USER_COMPANY, ['engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '用户公司表', 'id' => false]);
        $table->addColumn(Column::integer('uid')->setDefault(0)->setComment('UID'))
            ->addColumn(Column::integer('company_id')->setDefault(0)->setComment('Company ID'))
            ->create();
    }

    public function down()
    {
        if ($this->table(InitTable::TB_AUTH_USER_COMPANY)->exists()) {
            $this->table(InitTable::TB_AUTH_USER_COMPANY)->drop();
        }
    }
}
