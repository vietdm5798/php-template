<?php

class DB
{
    protected $connection;
    protected bool $connected = false;

    function __construct($db_host, $db_username, $db_password, $db_database)
    {
        try {
            $connection = new PDO("mysql:host=$db_host;dbname=$db_database;charset=utf8", $db_username, $db_password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $connection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");

            $this->connection = $connection;
            $this->connected = true;
        } catch (PDOException | Exception $e) {
            throw new DbException($e->getMessage());
        }
    }

    function __destruct()
    {
        $this->connected = false;
        $this->connection = null;
    }

    public function isConnected()
    {
        return $this->connected;
    }

    private function getConnection()
    {
        if (!$this->isConnected()) {
            throw new DbException('Not found DB connection!');
        }
        return $this->connection;
    }

    public function fetch($query, $parameters = [])
    {
        $conn = $this->getConnection();
        try {
            $query = $conn->prepare($query);
            $query->execute($parameters);
            return $query->fetch();
        } catch (PDOException | Exception $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function fetchAll($query, $parameters = [])
    {
        $conn = $this->getConnection();
        try {
            $query = $conn->prepare($query);
            $query->execute($parameters);
            return $query->fetchAll();
        } catch (PDOException | Exception $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function query($query, $parameters = []): void
    {
        $conn = $this->getConnection();
        try {
            $query = $conn->prepare($query);
            $query->execute($parameters);
        } catch (PDOException | Exception $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function insert($query, $parameters = [])
    {
        $conn = $this->getConnection();
        try {
            $query = $conn->prepare($query);
            $query->execute($parameters);
            return $conn->lastInsertId();
        } catch (PDOException | Exception $e) {
            throw new DbException($e->getMessage());
        }
    }
}
