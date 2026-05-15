<?php

namespace app\Core;

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

    private static function createDb(string $dbname): void
    {
        try {
            $stm = Db::getInstance()->prepare(
                "CREATE DATABASE IF NOT EXISTS $dbname COLLATE utf8_general_ci;"
            );
            $stm->execute();
        } catch (\PDOException $e) {
            error_log($e->getMessage());
        }
    }

        public static function createTable(string $table): void
    {
        try {
            $stm = Db::getInstance()->prepare(
                "CREATE TABLE IF NOT EXISTS $table;"
            );
            $stm->execute();
        } catch (\PDOException $e) {
            error_log($e->getMessage());
        }
    }

}
