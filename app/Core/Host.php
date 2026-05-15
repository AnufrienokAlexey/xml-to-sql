<?php

namespace app\Core;

use PDO;
use PDOException;

class Host
{
    protected static ?Host $_instance = null;
    private PDO $pdo;

    private function __construct(string $host, string $username, string $password)
    {
        $dsn = "mysql:host=$host";
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
}
