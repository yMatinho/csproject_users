<?php

namespace Framework\Factory;

use Framework\Controller\Controller;
use Framework\Singleton\Page\Page;
use Framework\View\View;

class ControllerFactory
{
    public function __construct()
    {
    }

    public function makeFromString(string $className): Controller
    {
        return new $className();
    }
}
