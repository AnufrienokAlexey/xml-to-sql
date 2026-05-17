<?php

namespace app\Models;

use app\Core\Db;
use PDOException;
use PDO;

class DataModel extends Db
{
    public static function insertData(string $table, string $column, string $data)
    {
        $table = addslashes($table);
        $column = addslashes($column);
        $data = addslashes($data);
        dump($table, $column, $data);

        if (!self::isExistData($table, $column, $data)) {
            try {
                $stm = parent::getInstance()->prepare(
                    "INSERT INTO $table ($column) VALUES ($data);"
                );
                dump($stm->execute());
            } catch (\PDOException $e) {
                error_log($e->getMessage());
            }
        } else {
            dump("data is existed");
        }
    }

    public static function isExistData(string $table, string $column, string $data)
    {
        try {
            $stm = parent::getInstance()->prepare(
                "SELECT * FROM $table WHERE $column = `$data`;"
            );
            return $stm->execute();
        } catch (\PDOException $e) {
            error_log($e->getMessage());
        }
    }
}
