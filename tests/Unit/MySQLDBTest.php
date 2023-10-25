<?php

use Framework\DB\MySQLDB;

class MySQLDBTest extends PHPUnit\Framework\TestCase
{
    public function testConnection()
    {
        $db = MySQLDB::get();
        $this->assertInstanceOf(PDO::class, $db->connection());
    }

    public function testRawQuery()
    {
        $db = MySQLDB::get();

        $query = "CREATE TABLE test (id INT)";
        $this->assertNull($db->rawQuery($query));

        $query = "INSERT INTO test (id) VALUES (1)";
        $db->rawQuery($query);
        $query = "SELECT * FROM test";
        $this->assertEquals(['id' => 1, 0=>1], $db->rawQuery($query, true, false));

        $query = "INSERT INTO test (id) VALUES (2), (3)";
        $db->rawQuery($query);
        $query = "SELECT * FROM test";
        $this->assertEquals([['id' => 1, 0=>1], ['id' => 2, 0=>2], ['id' => 3, 0=>3]], $db->rawQuery($query, true, true));

        $query = "DROP TABLE test";
        $db->rawQuery($query);
    }
}
