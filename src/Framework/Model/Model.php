<?php

namespace Framework\Model;

use Exception;
use Framework\DB\DB;
use Framework\DB\MySQLDB;
use Framework\DB\Query\Clausure\WhereClausure;
use Framework\DB\Query\Clausure\WhereComparison;
use Framework\DB\Query\MySQLQueryFactory;
use Framework\DB\Table\Table;
use Framework\Factory\CollectionFactory;

abstract class Model
{
    protected static Table $table;
    protected array $modelValues;

    protected function __construct()
    {
        $this->modelValues = [];
    }

    abstract static function init(): void;

    public function __set($name, $value)
    {
        $this->modelValues[$name] = $value;
    }

    public function __get($name)
    {
        return $this->modelValues[$name];
    }
    public static function fromData(array $data): Model
    {
        return self::fillModel(new static(), $data);
    }

    public function toArray(): array {
        return $this->modelValues;
    }
    protected static function fillModel(Model $model, array $data): Model
    {
        if(isset($data["id"]))
            $model->id = $data["id"];
        
        foreach (self::$table->getCollumns() as $collumn) {
            if(isset($data[$collumn])) {
                $model->$collumn = $data[$collumn];
            }
        }

        return $model;
    }
    public function save(): void
    {
        if (array_key_exists('id', $this->modelValues))
            $this->update();
        else
            $this->insert();
    }

    protected function insert(): void
    {
        $bruteInsertData = $this->prepareValuesToSqlQuery();
        $queryFactory = new MySQLQueryFactory(self::$table);
        $query = $queryFactory->insert($this->getValues($bruteInsertData), $this->getCollumns($bruteInsertData));

        MySQLDB::get()->rawQuery($query);
    }
    protected function update(): void
    {
        $bruteUpdateData = $this->prepareValuesToSqlQuery();
        $queryFactory = new MySQLQueryFactory(self::$table);
        $query = $queryFactory->update(["id" => $this->modelValues['id']], $this->getValues($bruteUpdateData), $this->getCollumns($bruteUpdateData));
        
        MySQLDB::get()->rawQuery($query);
    }
    public static function delete(string|int $id): void
    {
        $queryFactory = new MySQLQueryFactory(self::$table);
        $query = $queryFactory->delete(["id" => $id]);
        
        MySQLDB::get()->rawQuery($query);
    }
    public static function all(string $fields = "*", string $orderBy = "", string $orderByOrder = "", ?int $limit = null): Collection
    {
        $queryFactory = new MySQLQueryFactory(self::$table);
        $query = $queryFactory->select([], $fields, $orderBy, $orderByOrder, (string)$limit ?: "");

        return (new CollectionFactory())->makeFromQueryResults(MySQLDB::get()->rawFetchQuery($query, true), static::class);
    }

    public static function first(string $fields = "*", bool $throwNotFoundException=false): Model
    {
        $queryFactory = new MySQLQueryFactory(self::$table);
        $query = $queryFactory->select([], $fields, "id", "DESC", 1);
        
        $model = self::fromData(MySQLDB::get()->rawFetchQuery($query));

        if($model->isEmpty() && $throwNotFoundException) {
            throw new \Exception(sprintf("Model %s not found", static::class));
        }

        return $model;
    }

    public static function find(int|string $id, bool $throwNotFoundException=false): Model
    {
        $model = self::fromData(self::select([
            (new WhereClausure([
                (new WhereComparison("id", "=", $id))
            ]))
        ], "*", "", "", 1));

        if($model->isEmpty() && $throwNotFoundException) {
            throw new \Exception(sprintf("Model %s not found", static::class));
        }

        return $model;
    }

    private static function select(array $clausures, $fields = "*", $orderBy = "", $orderByOrder = "", $limit = ""): array
    {
        $queryFactory = new MySQLQueryFactory(self::$table);
        $query = $queryFactory->select($clausures, $fields, $orderBy, $orderByOrder, $limit);
        
        return MySQLDB::get()->rawFetchQuery($query, ($limit > 1 || $limit == null));
    }

    public function isEmpty(): bool {
        return empty($this->modelValues);
    }

    private function getValues($data): array
    {
        return array_values($data);
    }
    private function getCollumns($data): array
    {
        return array_keys($data);
    }
    private function prepareValuesToSqlQuery(): array
    {
        $filteredModelValues = $this->modelValues;
        unset($filteredModelValues["id"]);

        return array_map(function ($value) {
            return ["value" => $value, "type" => gettype($value)];
        }, $filteredModelValues);
    }
}
