<?php

namespace Framework\DB\Table;

class Table {
    protected string $table;
    protected array $collumns;
    
    public function __construct(string $table, array $collumns)
    {
        $this->table = $table;
        $this->collumns = $collumns;
    }

    public function getTable(): string {
        return $this->table;
    }

    public function getCollumns(): array {
        return $this->collumns;
    }
}