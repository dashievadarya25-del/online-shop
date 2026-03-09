<?php
namespace Model;
use PDO;

abstract class Model
{
    protected PDO $PDO;

    public function __construct()
    {
        $this->PDO = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
    }

    abstract protected function getTableName(): string;
}
