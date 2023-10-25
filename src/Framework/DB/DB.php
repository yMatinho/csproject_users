<?php

namespace Framework\DB;

abstract class DB {
    protected $username;
    protected $password;
    protected $database;
    protected $host;

    protected function __construct($username=DB_USERNAME, $password=DB_PASSWORD, $database=DB_DATABASE, $host=DB_HOST)
    {
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->host = $host;
    }

    abstract function connection();
    abstract function rawQuery(string $query);
    abstract function rawFetchQuery(string $query, bool $returnMany=false);
}