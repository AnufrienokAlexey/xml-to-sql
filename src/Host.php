<?php

class Host extends Db
{
    private function connectToHost()
    {
        try {
            $host = parent::getHost();
            $username = parent::getUsername();
            $password = parent::getPassword();

            return new PDO("mysql:host=$host", $username, $password);
        }
        catch (PDOException $e) {
            return self::getPdoException($e);
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
            return self::getPdoException($e);
        }
    }
}
