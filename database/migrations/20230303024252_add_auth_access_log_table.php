<?php

use auth\InitTable;
use Phinx\Db\Adapter\MysqlAdapter;
use think\migration\db\Column;
use think\migration\Migrator;

class AddAuthAccessLogTable extends Migrator
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
        $table = $this->table(InitTable::TB_AUTH_ACCESS_LOG, ['engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '访问日志表', 'id' => 'id', 'primary_key' => ['id']]);
        $table->addColumn('uid', 'integer', ['limit' => MysqlAdapter::INT_MEDIUM, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '用户id'])
            ->addColumn('url', 'string', ['limit' => 256, 'null' => false, 'default' => '', 'signed' => false, 'comment' => '访问url'])
            ->addColumn(Column::longText('token')->setDefault('')->setComment('Token'))
            ->addColumn(Column::string('rule')->setDefault('')->setComment('Rule'))
            ->addColumn(Column::string('ip')->setDefault('')->setComment('IP'))
            ->addColumn('get', 'json', ['null' => false, 'signed' => false, 'comment' => 'get参数'])
            ->addColumn('post', 'json', ['null' => false, 'signed' => false, 'comment' => 'post参数'])
            ->addColumn('server_info', 'json', ['null' => false, 'signed' => false, 'comment' => '服务器信息'])
            ->addColumn('create_time', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'null' => false, 'default' => 0, 'signed' => false, 'comment' => '访问时间'])
            ->addIndex(['uid'], ['name' => 'user_info'])
            ->create();
    }

    public function down()
    {
        if ($this->table(InitTable::TB_AUTH_ACCESS_LOG)->exists()) {
            $this->table(InitTable::TB_AUTH_ACCESS_LOG)->drop();
        }
    }
}
