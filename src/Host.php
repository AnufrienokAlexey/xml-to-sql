<?php

class Host extends Db
{
    public function connectToHost()
    {
        try {
            $host = parent::getHost();
            $username = parent::getUsername();
            $password = parent::getPassword();

            return new PDO("mysql:host=$host", $username, $password);
        }

        catch (PDOException $e) {
            return "error";
        }
    }

    public function createDb(string $dbname)
    {
        try {
            $sth = $this->connectToHost()->prepare("CREATE DATABASE IF NOT EXISTS $dbname");
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_COLUMN);
        }

        catch (PDOException $e) {
            return "Error createDb(): " . $e->getMessage();
        }
    }
}
