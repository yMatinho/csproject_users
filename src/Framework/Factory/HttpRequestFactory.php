<?php

namespace Framework\Factory;

use Framework\Controller\Controller;
use Framework\Request\HttpRequest;
use Framework\Singleton\Page\Page;
use Framework\View\View;

class HttpRequestFactory extends RequestFactory
{
    public function __construct()
    {
    }

    public function make(): HttpRequest
    {
        return new HttpRequest(array_merge($_GET, $_POST));
    }
}
