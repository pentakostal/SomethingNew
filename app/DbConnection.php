<?php

namespace App;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception\DatabaseDoesNotExist;

class DbConnection
{
    private static DbConnection $database;
    private \Doctrine\DBAL\Connection $connection;

    public function __construct()
    {
        $connectionParams = [
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['DB_HOST'],
            'driver' => $_ENV['DB_DRIVER'],
        ];

        $this->connection = DriverManager::getConnection($connectionParams);
    }

    public function getConnection(): \Doctrine\DBAL\Connection
    {
        return $this->connection;
    }

    public static function getDataBase(): DbConnection
    {
        if (self::$database == null) {
            self::$database = new DbConnection();
        }

        return self::$database;
    }
}