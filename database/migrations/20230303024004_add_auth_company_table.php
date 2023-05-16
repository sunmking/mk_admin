<?php

use auth\InitTable;
use think\migration\db\Column;
use think\migration\Migrator;

class AddAuthCompanyTable extends Migrator
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
        $table = $this->table(InitTable::TB_AUTH_COMPANY, ['engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '公司表', 'id' => 'id', 'primary_key' => ['id']]);
        $table->addColumn(Column::string('name', 128)->setDefault('')->setComment('名称'))
            ->addColumn(Column::string('simple_name', 64)->setDefault('')->setComment('简称'))
            ->addColumn(Column::string('simple_pinyin', 32)->setDefault('')->setComment('拼音简称'))
            ->addColumn(Column::string('address', 255)->setDefault('')->setComment('地址'))
            ->addColumn(Column::tinyInteger('status')->setDefault(1)->setComment('状态'))
            ->addColumn(Column::integer('delete_time')->setDefault(0)->setComment('删除'))
            ->addColumn(Column::integer('create_time')->setDefault(0)->setComment('创建时间'))
            ->addColumn(Column::integer('update_time')->setDefault(0)->setComment('更新时间'))
            ->create();
    }

    public function down()
    {
        if ($this->table(InitTable::TB_AUTH_COMPANY)->exists()) {
            $this->table(InitTable::TB_AUTH_COMPANY)->drop();
        }
    }
}
