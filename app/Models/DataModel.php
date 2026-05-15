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
        $sqlArray = null;
        $sql = null;
        // $sql = "SELECT * FROM";
        // $pdo = Db::getInstance()->prepare($sql);
        dump($array);

        foreach ($array as $table) {
            if (count($table) > 1) {
                foreach ($table as $key => $column) {
                    $sql =
                }
            }
        }
    }
}
