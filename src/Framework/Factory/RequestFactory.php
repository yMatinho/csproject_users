<?php

namespace Framework\Factory;

use Framework\Controller\Controller;
use Framework\Request\HttpRequest;
use Framework\Request\Request;
use Framework\Singleton\Page\Page;
use Framework\View\View;

abstract class RequestFactory
{

    abstract public function make(): Request;
}
