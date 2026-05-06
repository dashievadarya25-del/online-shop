<?php

namespace Model;

use PDO;

abstract class Model
{
    protected static PDO $PDO;

    public static function getPDO(): PDO
    {
        if (!isset(self::$PDO)) {
            static::$PDO = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
        }
        return static::$PDO;
    }

    abstract protected static function getTableName(): string;
}
