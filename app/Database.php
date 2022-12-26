<?php

namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;


class Database
{
    private static ?Connection $connection = null;

    public static function getConnection(): ?Connection
    {
        if (self::$connection == null) {
            $connectionParams = [
                'dbname' => $_ENV['DB_NAME'],
                'user' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
                'host' => $_ENV['DB_HOST'],
                'driver' => "pdo_mysql",
            ];
            self::$connection = DriverManager::getConnection($connectionParams);
        }

        return self::$connection;
    }

}