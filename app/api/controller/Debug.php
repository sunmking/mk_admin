<?php

namespace app\api\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\Env;

class Debug extends BaseController
{
    /**
     * 获取表所有字段
     *
     * @return mixed|null
     */
    protected function getTableColumns(string $table = ''): mixed
    {
        $dbName = Env::get('database.database');
        $tableName = $table;
        if ($tableName === null) {
            display('没有获取到对应的表');

            return null;
        }

        $tableNameFull = Env::get('database.prefix').$tableName;
        // 获取所有列
        $result = Db::query("SELECT COLUMN_NAME, COLUMN_COMMENT, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$dbName."' AND TABLE_NAME = '".$tableNameFull."'");
        if (empty($result)) {
            display('表 [ '.$tableNameFull.' ]  COLUMN 为空');

            return null;
        }

        return $result;
    }

    public function transformer(string $table = '', bool $simple = true): void
    {
        $data = $this->getTableColumns($table);
        $emptyValue = $this->request->get('ev', 0);

        //var_dump($data);

        $phpArrayCode = '[
        '.'<br/>';
        if ($simple == 'false') {
            foreach ($data as $v) {
                // 过滤一些字段
                if (in_array($v['COLUMN_NAME'], ['delete_time', 'update_time', 'status', 'total', 'quantity', 'auditor', 'deal_time', 'creator_id', 'order_detail_ids', 'creator_department_id'])) {
                    continue;
                }

                if (!empty($emptyValue)) {
                    $phpArrayCode .= '\''.$v['COLUMN_NAME'].'\' => ';
                }

                if (mb_substr($v['COLUMN_NAME'], -5) === '_time') {
                    $phpArrayCode .= '[
                    <br/>   \'name\' => \''.$v['COLUMN_COMMENT'].'\',';
                    $phpArrayCode .= '\'field\' => \''.$v['COLUMN_NAME'].'\',';
                    //                    $phpArrayCode .='\'type\' => \'datetime\',';
                    $phpArrayCode .= '\'require\' => true,';
                    //                    $phpArrayCode .='\'state\' => \'editable\',';
                    $phpArrayCode .= '\'option\' => [],';
                    if (empty($emptyValue)) {
                        $phpArrayCode .= '\'value\' => isset($item[\''.$v['COLUMN_NAME'].'\'])?$item[\''.$v['COLUMN_NAME'].'\']:"",';
                    } else {
                        $phpArrayCode .= '\'value\' => \'\',';
                    }
                } else {
                    $phpArrayCode .= '[
                    <br/>   \'name\' => \''.$v['COLUMN_COMMENT'].'\',';
                    $phpArrayCode .= '\'field\' => \''.$v['COLUMN_NAME'].'\',';
                    //                    $phpArrayCode .='\'type\' => \'text\',';
                    $phpArrayCode .= '\'require\' => true,';
                    //                    $phpArrayCode .='\'state\' => \'editable\',';
                    $phpArrayCode .= '\'option\' => [],';
                    if (empty($emptyValue)) {
                        $phpArrayCode .= '\'value\' => isset($item[\''.$v['COLUMN_NAME'].'\'])?$item[\''.$v['COLUMN_NAME'].'\']:"",';
                    } else {
                        $phpArrayCode .= '\'value\' => \'\',';
                    }
                }

                if (in_array($v['COLUMN_NAME'], ['id', 'cargo_id'])) {
                    $type = 'hidden';
                    $phpArrayCode .= "'type' => 'hidden', ";
                    $phpArrayCode .= "'hint' => '', ";
                } elseif (mb_substr($v['COLUMN_NAME'], -3) == '_id') {
                    $type = 'select';
                    $phpArrayCode .= "'type' => 'select', ";
                    $phpArrayCode .= "'hint' => '请选择', ";
                } else {
                    $type = 'text';
                    $phpArrayCode .= "'type' => 'text', ";
                    $phpArrayCode .= "'hint' => '请输入', ";
                }

                if ($type == 'hidden') {
                    $phpArrayCode .= " 'state' => 'readonly'";
                } else {
                    $phpArrayCode .= " 'state' => 'editable'";
                }

                $phpArrayCode .= '
                <br/>],'
                    .'<br/>';
            }
        } else {
            foreach ($data as $v) {
                if (mb_substr($v['COLUMN_NAME'], -5) === '_time') {
                    $phpArrayCode .= '\''.$v['COLUMN_NAME'].'\'=> $item[\''.$v['COLUMN_NAME'].'\']?:"",
                '.'<br/>';
                } else {
                    $phpArrayCode .= '\''.$v['COLUMN_NAME'].'\'=> $item[\''.$v['COLUMN_NAME'].'\']?:"",
                '.'<br/>';
                }
            }
        }

        $phpArrayCode .= '
        ];';

        echo $phpArrayCode;
    }

    /**
     * @param  string  $table
     */
    public function outPutJsonTable($table = '')
    {
        $fields = Db::table($table)->getTableFields();
        $fields = array_flip($fields);
        //ksort($fields);
        array_walk($fields, function (&$item) {
            $item = '';
        });
        echo \json_encode($fields);
    }
}
