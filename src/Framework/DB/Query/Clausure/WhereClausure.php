<?php

namespace Framework\DB\Query\Clausure;

class WhereClausure {
    private bool $subclausure;
    private string $logicalOperator;
    private array $comparisons;

    public function __construct(array $comparisons, string $logicalOperator = "", bool $subclausure = false)
    {
        $this->comparisons = $comparisons;
        $this->subclausure = $subclausure;
        $this->logicalOperator = $logicalOperator;
    }

    public function get(): string {
        $whereContent = "";

        foreach($this->comparisons as $key=>$comparison)
            $whereContent .= $this->logicalOperator." ".($this->subclausure ? "(" : "").$comparison->get($key != 0).($this->subclausure ? ")" : "")." ";

        return $whereContent;
    }

    public function getComparisons(): array {
        return $this->comparisons;
    }
}