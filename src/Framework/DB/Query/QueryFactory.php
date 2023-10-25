<?php

namespace Framework\DB\Query;

use Framework\DB\Table\Table;

abstract class QueryFactory {
    protected Table $table;
    protected function __construct(Table $table)
    {
        $this->table = $table;
    }

    abstract function insert(array $values, array $collumns=null): string;
    abstract function select(array $clausures, string $fields="*", string $orderBy = "", string $orderByOrder = "ASC", string $limit = ""): string;
    abstract function update(array $idAndValue, array $values, array $collumns = null): string;
    abstract function delete(array $idAndValue): string;

}