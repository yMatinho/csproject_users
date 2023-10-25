<?php
include("config.php");
include("vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use Framework\DB\Table\Table;
use Framework\DB\Query\Builder\Select\MySQLSelectQueryBuilder;
use Framework\DB\Query\Builder\Select\SelectQueryDirector;
use Framework\DB\Query\Clausure\WhereClausure;
use Framework\DB\Query\Clausure\WhereComparison;

class SelectQueryBuilderTest extends TestCase
{
    public function testPartInitial()
    {
        $table = new Table('users', ['id', 'name', 'email']);
        $builder = new MySQLSelectQueryBuilder($table, [], 'id, name');
        $this->assertEquals(trim("SELECT id, name FROM `users` "), trim($builder->partInitial()));
    }

    public function testPartClausures()
    {
        $table = new Table('users', ['id', 'name', 'email']);
        $clausures = [
            new WhereClausure([
                new WhereComparison('id', '=', 1, ""),
                new WhereComparison('name', 'LIKE', '\'%john%\'', "AND"),
                new WhereComparison('active', '=', 1, "AND")
            ])
        ];
        $builder = new MySQLSelectQueryBuilder($table, $clausures);
        $this->assertEquals(str_replace(" ", "", " WHERE id = 1 AND name LIKE '%john%' AND active = 1"), str_replace(" ", "", $builder->partClausures()));
    }

    public function testPartLimit()
    {
        $table = new Table('users', ['id', 'name', 'email']);
        $builder = new MySQLSelectQueryBuilder($table, []);
        $this->assertEquals(str_replace("  ", "", " LIMIT 10 "), $builder->partLimit(10));
    }

    public function testPartOrderBy()
    {
        $table = new Table('users', ['id', 'name', 'email']);
        $builder = new MySQLSelectQueryBuilder($table, []);
        $this->assertEquals(" ORDER BY created_at DESC ", $builder->partOrderBy('created_at', 'DESC'));
    }

    public function testMakeQuery()
    {
        $table = new Table('users', ['id', 'name', 'email']);
        $builder = new MySQLSelectQueryBuilder($table, [], 'id, name');
        $director = new SelectQueryDirector($builder, 'created_at', 'ASC', 20);
        $this->assertEquals(str_replace(" ", "", "SELECT id, name FROM `users`  ORDER BY created_at ASC LIMIT 20 "), str_replace(" ", "", $director->makeQuery()));
    }
}
