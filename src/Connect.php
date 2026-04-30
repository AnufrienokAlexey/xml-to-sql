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

    public function getAllTable()
    {
        $dbname = parent::getDbname();
        try {
            $sth = $this->getDatabase()->prepare("SHOW TABLES");
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_COLUMN);
        }
        catch(PDOException $e) {
            $this->getException($e, $dbname);
        }
    }

        public function getTable(string $table)
    {
        $dbname = parent::getDbname();
        try {
            $sth = $this->getDatabase()->prepare("SHOW TABLES LIKE :table");
            $sth->bindValue('table', $table);
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_ASSOC);
            //  return $this->getDatabase()->query("SELECT * FROM $dbname");
        }
        catch(PDOException $e) {
            $this->getException($e, $dbname);
        }
    }

    public function createTable(string $table)
    {
        if (sizeof($this->getTable($table)) > 0) {
            echo "Таблица $table уже существует. Новая таблица с таким именем не будет создана.";
            return;
        }
        $dbname = parent::getDbname();
        try {
            $sth = $this->getDatabase()->prepare("
                CREATE TABLE IF NOT EXISTS rest';
            ");
            // $sth->bindValue(':table', $table);
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_ASSOC);
            // return "Новая таблица $table успешно создана в базе данных $dbname";
        }
        catch(PDOException $e) {
            $this->getException($e, $dbname);
        }
    }
}
