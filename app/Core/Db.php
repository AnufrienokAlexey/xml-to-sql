<?php

namespace app\Core;

use app\Core\Host;
use app\Models\DataModel;
use PDO;
use PDOException;

class Db
{
    protected static ?Db $_instance = null;
    private PDO $pdo;

    private function __construct(string $host, string $dbname, string $charset, string $username, string $password)
    {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            echo self::getPdoException($e);
        }
    }

    public static function getInstance(): PDO
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self(
                getenv('DB_HOST'),
                getenv('DB_NAME'),
                getenv('DB_CHARSET'),
                getenv('DB_USER'),
                getenv('DB_PASS'),
            );
        }

        return self::$_instance->pdo;
    }

    protected static function getPdoException(PDOException $e): string
    {
        return "Error: " . $e->getMessage();
    }

    public static function createDb()
    {
        $dbname = getenv('DB_NAME');
        try {
            $stm = Host::getInstance()->prepare(
                "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci"
            );
            return $stm->execute();
        } catch (\PDOException $e) {
            error_log($e->getMessage());
        }
    }

    public static function createTable(string $table)
    {
        if (!self::isTableExist($table)) {
            try {
                $stm = self::getInstance()->prepare(
                    "CREATE TABLE IF NOT EXISTS $table (`id` INT AUTO_INCREMENT PRIMARY KEY)
                    ENGINE=InnoDB
                    DEFAULT CHARSET=utf8mb4
                    COLLATE=utf8mb4_0900_ai_ci;"
                );
                return $stm->execute();
            } catch (\PDOException $e) {
                error_log($e->getMessage());
            }
        }
    }

    public static function isTableExist(string $table)
    {
        try {
            $stm = Db::getInstance()->prepare(
                "SHOW TABLES"
            );
            $stm->execute();
            $res = $stm->fetchAll(PDO::FETCH_COLUMN);
            return in_array($table, $res);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
        }
    }

    public static function createColumn(string $table, string $column)
    {
        if(!self::isColumnExist($table, $column)) {
            try {
                $stm = self::getInstance()->prepare(
                    "ALTER TABLE $table ADD :column TEXT;"
                );
                $stm->bindColumn(':column', $column);
                return $stm->execute();
            } catch (\PDOException $e) {
                error_log($e->getMessage());
            }
        }
    }

    public static function isColumnExist(string $table, string $column)
    {
        try {
            $stm = Db::getInstance()->prepare(
                "DESCRIBE $table"
            );
            $stm->execute();
            $res = $stm->fetchAll(PDO::FETCH_COLUMN);
            return in_array($column, $res);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
        }
    }

    public static function setData(array $array)
    {
        foreach ($array as $table => $value) {
            if (self::createTable($table)) {
                echo("Таблица $table успешно создана" . PHP_EOL);
            }
            if (array_is_list($value)) {
                foreach($value as $item) {
                    foreach ($item as $column => $data) {
                        if (self::createColumn($table, $column)) {
                            echo("Колонка $column в таблице $table успешно создана" . PHP_EOL);
                        }
                        // DataModel::insertData($table, $column, $data);
                    }
                } 
            } else {
                foreach ($value as $column => $data) {
                    if (self::createColumn($table, $column)) {
                        echo("Колонка $column в таблице $table успешно создана" . PHP_EOL);
                    }
                    // DataModel::insertData($table, $column, $data);
                }
            }
        }
    }
}
