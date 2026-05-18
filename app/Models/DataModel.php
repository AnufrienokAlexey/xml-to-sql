<?php

namespace app\Models;

use app\Core\Db;
use PDOException;
use PDO;

class DataModel extends Db
{
    public static function insertData(string $table, string $column, string $data)
    {
        dump("table = $table");
        dump("column = $column");
        dump("data = $data");

        if (!self::isExistData($table, $column, $data)) {
            try {
                $stm = parent::getInstance()->prepare(
                    "INSERT INTO $table (:column) VALUES (:data);"
                );
                $stm->bindParam(':column', $column);
                $stm->bindParam(':data', $data);
            } catch (\PDOException $e) {
                error_log($e->getMessage());
            }
        } else {
            dump("данные уже добавлены были ранее");
        }
    }

    public static function isExistData(string $table, string $column, string $data)
    {
        try {
            $stm = parent::getInstance()->prepare(
                "SELECT * FROM $table WHERE :column = :data;"
            );
            $stm->bindParam(':column', $column);
            $stm->bindParam(':data', $data);
            $stm->execute();
            return $stm->execute();
        } catch (\PDOException $e) {
            error_log($e->getMessage());
        }
    }
}
