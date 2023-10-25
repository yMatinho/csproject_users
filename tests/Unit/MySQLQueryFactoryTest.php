<?php

use Framework\DB\Query\Clausure\WhereClausure;
use Framework\DB\Query\Clausure\WhereComparison;
use PHPUnit\Framework\TestCase;
use Framework\DB\Table\Table;
use Framework\DB\Query\MySQLQueryFactory;

class MySQLQueryFactoryTest extends TestCase
{
    public function testInsert()
    {
        $table = new Table('users', ['name', 'email', 'password']);
        $queryFactory = new MySQLQueryFactory($table);
        $values = [
            ['type' => 'string', 'value' => 'John Doe'],
            ['type' => 'string', 'value' => 'johndoe@example.com'],
            ['type' => 'string', 'value' => 'password']
        ];
        $query = $queryFactory->insert($values);
        $this->assertEquals("INSERT INTO users(name, email, password) VALUES('John Doe', 'johndoe@example.com', 'password')", $query);
    }

    public function testSelect()
    {
        $table = new Table('users', ['id', 'name', 'email', 'password']);
        $queryFactory = new MySQLQueryFactory($table);
        $clausures = [
            new WhereClausure([
                new WhereComparison('id', '=', 1),
                new WhereComparison('name', 'LIKE', '\'%john%\''),
                new WhereComparison('active', '=', 1)
            ])
        ];
        $query = $queryFactory->select($clausures, 'name, email');
        $this->assertEquals(str_replace(" ", "", "SELECT name, email FROM `users` WHERE  id = 1 AND name LIKE '%john%' AND active = 1"), str_replace(" ", "", $query));
    }

    public function testUpdate()
    {
        $table = new Table('users', ['id', 'name', 'email', 'password']);
        $queryFactory = new MySQLQueryFactory($table);
        $values = [
            ['type' => 'string', 'value' => 'Jane Doe'],
            ['type' => 'string', 'value' => 'janedoe@example.com'],
            ['type' => 'string', 'value' => 'password']
        ];
        $identificator = ['id' => 1];
        $query = $queryFactory->update($identificator, $values);
        $this->assertEquals("UPDATE `users` SET name='Jane Doe',email='janedoe@example.com',password='password' WHERE id = 1", $query);
    }

    public function testDelete()
    {
        $table = new Table('users', ['id', 'name', 'email', 'password']);
        $queryFactory = new MySQLQueryFactory($table);
        $identificator = ['id' => 1];
        $query = $queryFactory->delete($identificator);
        $this->assertEquals("DELETE FROM `users` WHERE id = 1", $query);
    }
}
