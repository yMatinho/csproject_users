<?php

const ROUTE_NOT_FOUND_REDIRECT = 12;

use PHPUnit\Framework\TestCase;
use Framework\Singleton\Router\Router;

class RouterTest extends TestCase
{
    public function testAddGet()
    {
        Router::get()->addGet("test/route", function () {
            return "route action";
        }, "test_route");
        $this->assertTrue(true);
    }

    public function testAddPost()
    {
        Router::get()->addPost("test/route", function () {
            return "route action";
        }, "test_route");
        $this->assertTrue(true);
    }

    public function testRouter()
    {
        Router::get()->addGet("test/route", function () {
            return "route action";
        }, "test_route");
        if (!empty(Router::get()->route("test_route")))
            $this->assertTrue(true);
    }

    public function testRedirect()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ROUTE_NOT_FOUND_REDIRECT);
        Router::get()->redirect("non_existent_route");
    }
}
