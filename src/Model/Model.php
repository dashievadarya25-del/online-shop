<?php

declare(strict_types=1);

namespace Model;

use PDO;

abstract class Model
{
    protected static PDO $PDO;

    public static function getPDO(): PDO
    {
        if (!isset(static::$PDO)) {
            $host = getenv('DB_HOST') ?: 'postgres';
            $port = getenv('DB_PORT') ?: '5432';
            $name = getenv('DB_NAME') ?: 'mydb';
            $user = getenv('DB_USER') ?: 'user';
            $pass = getenv('DB_PASS') ?: 'pass';

            static::$PDO = new PDO(
                "pgsql:host=$host;port=$port;dbname=$name",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }

        return static::$PDO;
    }

    abstract protected static function getTableName(): string;
}

