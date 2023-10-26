<?php

namespace Framework\Command;

use Exception;
use Framework\Factory\ControllerFactory;
use Framework\Singleton\Router\HttpDefaultRouteNames;
use Framework\Singleton\Router\Route;
use Framework\Singleton\Router\Router;

abstract class ExecutionCommand
{
    protected ControllerFactory $controllerFactory;

    public function __construct()
    {
        $this->controllerFactory = new ControllerFactory();
    }

    abstract public function execute(): void;
}
