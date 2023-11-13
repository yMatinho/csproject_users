<?php

namespace Framework\DB;

use PDO;

class MySQLDB extends DB {
    protected $username;
    protected $password;
    protected $database;
    protected $host;
    private PDO $pdo;
    private static $instance;

    protected function __construct()
    {
        parent::__construct(DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_HOST);
    }

    public static function get():MySQLDB {
        if(!self::$instance)
            self::$instance = new MySQLDB();
        return self::$instance;
    }

    public function connection() {
        if(!empty($this->pdo)) 
            return $this->pdo;
        $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
        
        return $this->pdo;
    }
    public function rawQuery(string $rawQuery): void {
        $pdo = $this->connection();
        $query = $pdo->prepare($rawQuery);
        $query->execute();
    }

    public function rawQueryReturningLastId(string $rawQuery): int {
        $this->connection()->beginTransaction();
        $this->rawQuery($rawQuery);
        $id = $this->connection()->lastInsertId();
        $this->connection()->commit();

        return $id;
    }

    public function rawFetchQuery(string $rawQuery, $returnMany=false): array {
        $pdo = $this->connection();
        $query = $pdo->prepare($rawQuery);
        $query->execute();

        $returnedData = $query->fetchAll();
        if(!$returnMany) {
            return $returnedData ? $returnedData[0] : [];
        }
        return $returnedData;
    }
}