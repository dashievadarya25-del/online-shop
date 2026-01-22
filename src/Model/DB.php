<?php

class DB
{
    private PDO $PDO;

    public function __construct()
    {
        $this->PDO = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
    }

    /**
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->PDO;
    }
}