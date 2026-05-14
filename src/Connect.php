<?php

class Connect extends Db
{
    public function connect() : PDO|string
    {
        try {
            $host = parent::getHost();
            $username = parent::getUsername();
            $password = parent::getPassword();
            $dbname = parent::getDbname();
            $charset = parent::getCharset();

            return new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", "$username", "$password");
        }
        catch (PDOException $e) {
            return self::getPdoException($e);
        }
    }

    public function getException(Exception $e): void
    {
        echo "Неудачная попытка подключения к базе данных " . parent::getDbname() . " " . $e->getMessage();
    }

    public function getAllTable() : array|string
    {
        try {
            $sth = $this->connect()->prepare("SHOW TABLES");
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_COLUMN);
        }
        catch (PDOException $e) {
            return self::getPdoException($e);
        }
    }

        public function getTable(string $table) : array|string
    {
        try {
            $sth = $this->connect()->prepare("SHOW TABLES LIKE :table");
            $sth->bindValue('table', $table);
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            return self::getPdoException($e);
        }
    }

    public function createTable(string $table) : string
    {
        if (sizeof($this->getTable($table)) > 0) {
            echo "Таблица $table уже существует. Новая таблица с таким именем не будет создана.";
            return "1";
        }
        try {
            $sth = $this->connect();
            $sth->exec("CREATE TABLE IF NOT EXISTS $table (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL)");
            return "Новая таблица $table успешно создана";
        }
        catch (PDOException $e) {
            return self::getPdoException($e);
        }
    }

    public function dropAllTables() : bool|string
    {
        try {
            $sth = $this->connect();
            $db = parent::getDbname();
            $sth->exec("DROP DATABASE $db");
            return true;
        }
        catch (PDOException $e) {
            return self::getPdoException($e);
        }
    }
}
