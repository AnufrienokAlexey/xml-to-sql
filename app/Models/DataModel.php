<?php

namespace app\Models;

use app\Core\Db;

class DataModel
{
    public static function createTable(string $table)
    {
        Db::createTable($table);
    }

    public static function setData(array $array)
    {
        foreach ($array as $table => $value) {
            if(Db::createTable($table)) {
                if (array_is_list($value)) {
                    foreach($value as $key => $item) {
                        foreach ($item as $column => $data) {
                            if (Db::createColumn($table, $column)) {
                                dump("okk"); //createData
                            }
                        }
                    } 
                } else {
                    foreach ($value as $v => $data) {
                        if (Db::createColumn($table, $v)) {
                            dump("okkkkkkkk"); //createData
                        }
                    }
                }
            }
        }
    }
}
