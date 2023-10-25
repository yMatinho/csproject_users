<?php

use PHPUnit\Framework\TestCase;
use Framework\DB\Query\Clausure\WhereClausure;
use Framework\DB\Query\Clausure\WhereComparison;

class WhereComparisonTest extends TestCase
{
    public function testWhereComparison()
    {
        $comparison = new WhereComparison('id', '=', 1);
        $this->assertEquals(" id = 1", $comparison->get());
    }

}
