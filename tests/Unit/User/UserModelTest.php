<?php

namespace Tests\Unit\User;

use \App\Core\Model\User;
use Exception;
use \Framework\DB\MySQLDB;
use \Framework\DB\Query\Builder\Select\SelectQueryDirector;
use Framework\Model\Collection;
use Framework\Model\Model;
use Mockery;
use Mockery\MockInterface;
use \PDO;
use PHPUnit\Framework\TestCase;

const USER_ID = 1;
const INVALID_USER_ID = 2;

const USER_TEST_DATA = [
    "username" => "teste",
    "email" => "teste",
    "first_name" => "teste",
    "last_name" => "teste",
    "password" => "teste"
];

const USER_UPDATEMENT_TEST_DATA = [
    "id" => USER_ID,
    "username" => "teste",
    "email" => "teste",
    "first_name" => "teste",
    "last_name" => "teste",
    "password" => "teste"
];

const USER_INVALID_TEST_DATA = [
    "invalid_field" => "teste",
    "invalid_field_2" => "teste",
];

class UserModelTest extends TestCase
{
    private MockInterface $dbMock;
    public function testInit()
    {
        User::init();

        $this->assertTrue(true);
    }

    public function setUp(): void
    {
        $this->dbMock = Mockery::mock('overload:' . MySQLDB::class)->makePartial();

        $this->dbMock->shouldReceive('get')->andReturn($this->dbMock);
        $this->dbMock->shouldReceive('rawFetchQuery')->andReturn([USER_TEST_DATA, USER_TEST_DATA, USER_TEST_DATA]);
        $this->dbMock->shouldReceive('rawQuery')->andReturn();
    }
    public function testFromData()
    {
        $user = User::fromData(USER_TEST_DATA);

        if ($this->modelFieldsDoesntMatchTestData($user)) {
            $this->assertFalse(true);
            return;
        }

        $this->assertTrue(true);
    }
    public function testFromDataWithInvalidData()
    {
        $user = User::fromData(USER_INVALID_TEST_DATA);
        $didNotSaveTheInvalidField = !isset($user->invalid_field);

        if ($didNotSaveTheInvalidField) {
            $this->assertTrue(true);
            return;
        }

        $this->assertFalse(true);
    }
    public function testAll()
    {
        $all = User::all();

        $this->dbMock->shouldHaveReceived('rawFetchQuery', ["SELECT * FROM `users` ", true]);
        $this->assertInstanceOf(Collection::class, $all);
    }

    public function testAllWithSpecifications()
    {
        $all = User::all("username, password", "id", "ASC", 10);

        $this->dbMock->shouldHaveReceived('rawFetchQuery', [
            "SELECT username, password FROM `users`  ORDER BY id ASC  LIMIT 10 ",
            true
        ]);
        $this->assertInstanceOf(Collection::class, $all);
    }

    public function testFirst()
    {
        $first = User::first();

        $this->dbMock->shouldReceive("rawFetchQuery")->andReturn(USER_TEST_DATA);
        $this->dbMock->shouldHaveReceived('rawFetchQuery', [
            "SELECT * FROM `users`  ORDER BY id DESC  LIMIT 1 "
        ]);

        $this->assertInstanceOf(Model::class, $first);
    }

    public function testFind()
    {
        $first = User::find(USER_ID);

        $this->dbMock->shouldReceive("rawFetchQuery")->andReturn(USER_TEST_DATA);
        $this->dbMock->shouldHaveReceived('rawFetchQuery', [
            "SELECT * FROM `users`  WHERE    `id` = '" . USER_ID . "'   LIMIT 1 ",
            false
        ]);

        $this->assertInstanceOf(Model::class, $first);
    }

    public function testFindWithInvalidIdWithoutException()
    {
        $first = User::find(INVALID_USER_ID);

        $this->dbMock->shouldReceive("rawFetchQuery")->andReturn([]);
        $this->dbMock->shouldHaveReceived('rawFetchQuery', [
            "SELECT * FROM `users`  WHERE    `id` = '" . INVALID_USER_ID . "'   LIMIT 1 ",
            false
        ]);

        $this->assertInstanceOf(Model::class, $first);
        $this->assertTrue($first->isEmpty());
    }

    public function testFindWithInvalidId()
    {
        try {
            $first = User::find(INVALID_USER_ID, true);

            $this->dbMock->shouldReceive("rawFetchQuery")->andReturn([]);
            $this->dbMock->shouldHaveReceived('rawFetchQuery', [
                "SELECT * FROM `users`  WHERE    `id` = '" . INVALID_USER_ID . "'   LIMIT 1 ",
                false
            ]);

            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertTrue(true);
        }
    }

    public function testIsEmpty()
    {
        $model = new User();
        $this->assertTrue($model->isEmpty());

        $model->name = "teste";
        $this->assertFalse($model->isEmpty());
    }

    public function testSaveCreating()
    {
        $modelToBeCreated = User::fromData(USER_TEST_DATA);
        $modelToBeCreated->save();

        $this->dbMock->shouldHaveReceived(
            'rawQuery',
            [
                sprintf(
                    "INSERT INTO users(username, first_name, last_name, email, password) VALUES('%s', '%s', '%s', '%s', '%s')",
                    USER_TEST_DATA["username"],
                    USER_TEST_DATA["first_name"],
                    USER_TEST_DATA["last_name"],
                    USER_TEST_DATA["email"],
                    USER_TEST_DATA["password"],
                ),
            ]
        );

        $this->assertTrue(true);
    }

    public function testSaveUpdating()
    {
        $modelToBeCreated = User::fromData(USER_UPDATEMENT_TEST_DATA);
        $modelToBeCreated->save();

        $this->dbMock->shouldHaveReceived(
            'rawQuery',
            [
                sprintf(
                    "UPDATE `users` SET username='%s',first_name='%s',last_name='%s',email='%s',password='%s' WHERE id = %d",
                    USER_UPDATEMENT_TEST_DATA["username"],
                    USER_UPDATEMENT_TEST_DATA["first_name"],
                    USER_UPDATEMENT_TEST_DATA["first_name"],
                    USER_UPDATEMENT_TEST_DATA["email"],
                    USER_UPDATEMENT_TEST_DATA["password"],
                    USER_UPDATEMENT_TEST_DATA["id"],
                ),
            ]
        );

        $this->assertTrue(true);
    }

    public function testDelete()
    {
        User::delete(USER_ID);

        $this->dbMock->shouldHaveReceived(
            'rawQuery',
            [
                "DELETE FROM `users` WHERE id = " . USER_ID,
            ]
        );

        $this->assertTrue(true);
    }

    private function modelFieldsDoesntMatchTestData(User $user): bool
    {
        return $user->username != USER_TEST_DATA["username"]
            || $user->email != USER_TEST_DATA["email"]
            || $user->first_name != USER_TEST_DATA["first_name"] || $user->last_name != USER_TEST_DATA["last_name"];
    }

    public function tearDown(): void
    {
        Mockery::close();
    }
}
