<?php

namespace framework\utils;

use PDO;

class ConnectionFactory
{
    private static $pdo;

    public static function makeConnection(array $conf)
    {
        $driver = $conf['driver'];
        $host = $conf['host'];
        $schema = $conf['schema'];
        $username = $conf['username'];
        $password = $conf['password'];

        $dns = $driver . ':host=' . $host . ';dbname=' . $schema;

        self::$pdo = new PDO($dns, $username, $password);
    }

    public static function getConnection()
    {
        return self::$pdo;
    }
}
