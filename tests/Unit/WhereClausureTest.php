<?php

use PHPUnit\Framework\TestCase;
use Framework\DB\Query\Clausure\WhereClausure;
use Framework\DB\Query\Clausure\WhereComparison;

class WhereClausureTest extends TestCase
{
    public function testWhereClausure()
    {
        $clausure = new WhereClausure([
            new WhereComparison('id', '=', 1),
            new WhereComparison('name', 'LIKE', '\'%john%\'', "AND"),
            new WhereComparison('active', '=', 1, "AND")
        ]);
        $this->assertEquals(str_replace(" ", "", " id = 1 AND name LIKE '%john%' AND active = 1"), str_replace(" ", "", $clausure->get()));
    }

}
