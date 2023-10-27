<?php

namespace Framework\Factory;

use Framework\Controller\Controller;
use Framework\Request\ApiRequest;
use Framework\Request\HttpRequest;
use Framework\Singleton\Page\Page;
use Framework\View\View;

class ApiRequestFactory extends RequestFactory
{
    public function __construct()
    {
    }

    public function make(): ApiRequest
    {
        return new ApiRequest(array_merge($_GET, json_decode(file_get_contents('php://input'), true) ?: []));
    }
}
