<?php

namespace app\Models;

use app\Core\Db;

class DataModel
{
    public static function setData(string $table, string $column, string $data)
    {
        try {
            $stm = Db::getInstance()->prepare(
                "INSERT INTO $table ($column) VALUES ($data);"
            );
            return $stm->execute();
        } catch (\PDOException $e) {
            error_log($e->getMessage());
        }
    }
}
