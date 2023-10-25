<?php

namespace Framework\DB\Query\Clausure;

class WhereComparison {
    private string $operator;
    private string $collumn;
    private string $value;
    private string $logicalOperator;

    public function __construct(string $collumn, string $operator, string $value, string $logicalOperator="AND")
    {
        $this->operator = $operator;
        $this->collumn = $collumn;
        $this->value = $value;
        $this->logicalOperator = $logicalOperator;
    }

    public function get(bool $includeLogicalOperator=false) {
        return ($includeLogicalOperator ? $this->logicalOperator." " : " ")."$this->collumn $this->operator $this->value";
    }
    
}