<?php

class Connect extends Db
{
    public function connect() : PDO
    {
        $host = parent::getHost();
        $username = parent::getUsername();
        $password = parent::getPassword();
        $dbname = parent::getDbname();
        $charset = parent::getCharset();

        return new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", "$username", "$password");
    }

    public function getException(Exception $e): void
    {
        echo "Неудачная попытка подключения к базе данных " . parent::getDbname() . " " . $e->getMessage();
    }

    public function getAllTable()
    {
        $dbname = parent::getDbname();
        try {
            $sth = $this->connect()->prepare("SHOW TABLES");
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_COLUMN);
        }
        catch(PDOException $e) {
            $this->getException($e);
        }
    }

        public function getTable(string $table)
    {
        try {
            $sth = $this->connect()->prepare("SHOW TABLES LIKE :table");
            $sth->bindValue('table', $table);
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            $this->getException($e);
        }
    }

    public function createTable(string $table)
    {
        if (sizeof($this->getTable($table)) > 0) {
            echo "Таблица $table уже существует. Новая таблица с таким именем не будет создана.";
            return;
        }
        try {
            $sth = $this->connect();
            $sth->exec("CREATE TABLE IF NOT EXISTS $table (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100) NOT NULL)");
            return "Новая таблица $table успешно создана";
        }
        catch(PDOException $e) {
            $this->getException($e);
        }
    }

    public function dropAllTables()
    {
        try {
            $sth = $this->connect();
            $db = parent::getDbname();
            // $sth->bindValue('db', parent::getDbname());
            $sth->exec("DROP DATABASE $db");
            return true;
        }
        catch(PDOException $e) {
            $this->getException($e);
        }
    }
}
