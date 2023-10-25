<?php

namespace Framework\DB\Query;

use Framework\DB\Query\Builder\Select\MySQLSelectQueryBuilder;
use Framework\DB\Query\Builder\Select\SelectQueryDirector;
use Framework\DB\Query\QueryFactory;
use Framework\DB\Table\Table;

class MySQLQueryFactory extends QueryFactory
{
    public function __construct(Table $table)
    {
        parent::__construct($table);
    }

    public function insert(array $values, array $collumns = null): string
    {
        if (!$collumns)
            $collumns = $this->table->getCollumns();
        $values = array_map(function ($value) {
            if ($value['type'] == "string")
                return "'" . $value["value"] . "'";
            return $value['value'];
        }, $values);
        return "INSERT INTO " . $this->table->getTable() . "(" . implode(', ', $collumns) . ") VALUES(" . implode(', ', $values) . ")";
    }
    public function select(array $clausures, string $fields = "*", string $orderBy = "", string $orderByOrder = "ASC", string $limit = ""): string
    {
        $queryBuilder = new MySQLSelectQueryBuilder($this->table, $clausures, $fields);
        $queryDirector = new SelectQueryDirector($queryBuilder, $orderBy, $orderByOrder, $limit);

        return $queryDirector->makeQuery();
    }

    public function update(array $idAndValue, array $values, array $collumns = null): string
    {
        $collumns = $this->getCollumnsWithoutId($collumns);
        $values = array_map(function ($collumn, $value) {
            if ($value == null)
                return;
            if ($value['type'] == "string")
                return "$collumn='" . $value["value"] . "'";
            return $value['value'];
        }, $collumns, $values);
        $identificatorQuery = array_keys($idAndValue)[0] . ' = ' . $idAndValue[array_keys($idAndValue)[0]];
        return "UPDATE `" . $this->table->getTable() . "` SET " . (implode(',', $values)) . " WHERE $identificatorQuery";
    }
    public function delete(array $idAndValue): string
    {
        $identificatorQuery = array_keys($idAndValue)[0] . ' = ' . $idAndValue[array_keys($idAndValue)[0]];
        return "DELETE FROM `" . $this->table->getTable() . "` WHERE $identificatorQuery";
    }

    private function getCollumnsWithoutId(array $collumns): array
    {
        if (!$collumns)
            $collumns = $this->table->getCollumns();
        $collumns = array_filter($collumns, function ($value) {
            if ($value == "id")
                return false;
            return true;
        });

        return $collumns;
    }
}
