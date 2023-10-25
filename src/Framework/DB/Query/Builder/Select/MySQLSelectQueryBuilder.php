<?php

namespace Framework\DB\Query\Builder\Select;

use Framework\DB\Table\Table;

class MySQLSelectQueryBuilder implements ISelectQueryBuilder
{
    private Table $table;
    private array $clausures;
    private string $fields;

    public function __construct(Table $table, array $clausures, string $fields = "*")
    {
        $this->table = $table;
        $this->clausures = $clausures;
        $this->fields = $fields;
    }

    public function partInitial(): string
    {
        return "SELECT $this->fields FROM `".$this->table->getTable()."` ";
    }

    public function partClausures(): string
    {
        $content = "";
        if(!empty($this->clausures))
            $content.=" WHERE ";
        foreach ($this->clausures as $key => $clausure)
            $content .= " " . $clausure->get() . " ";
        return $content;
    }

    public function partLimit($limit = 0): string
    {
        if ($limit)
            return " LIMIT $limit ";
        return '';
    }

    public function partOrderBy($orderBy = "", $orderByOrder = ""): string
    {
        if ($orderBy)
            return " ORDER BY $orderBy $orderByOrder ";
        return '';
    }
}
