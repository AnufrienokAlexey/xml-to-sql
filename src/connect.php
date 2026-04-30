<?php

class Connect extends Db {

    public function getDatabase() : PDO
    {
        $host = parent::getHost();
        $username = parent::getUsername();
        $password = parent::getPassword();
        $dbname = parent::getDbname();
        $charset = parent::getCharset();

        return new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", "$username", "$password");
    }

    public function getException(Exception $e, string $dbname): void
    {
        echo "Неудачная попытка подключения к базе данных $dbname: " . $e->getMessage();
    }
}
