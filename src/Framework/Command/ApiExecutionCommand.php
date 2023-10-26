<?php

namespace Framework\Command;

use Exception;
use Framework\Factory\ControllerFactory;
use Framework\Singleton\Router\HttpDefaultRouteNames;
use Framework\Singleton\Router\Route;
use Framework\Singleton\Router\Router;

class ApiExecutionCommand extends ExecutionCommand
{

    public function __construct(private readonly string $url) {
        parent::__construct();
    }

    public function execute(): void
    {
        $this->makeActionByUrl($this->url);
    }


    private function makeActionByUrl(string $url): void
    {
        try {
            $route = Router::get()->detectRouteByUrl($url);

            if (is_callable($route->getAction())) {
                echo $route->getAction()();
                return;
            }

            $this->callRouteActionFromController($route);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function callRouteActionFromController(Route $route): void
    {
        try {
            $controller = $this->controllerFactory->makeFromString(explode("@", $route->getAction())[0]);
            $methodName = explode("@", $route->getAction())[1];

            $result = $controller->$methodName();

            echo is_array($result) ? json_encode($result) : $result;
        } catch (Exception $e) {
            $treatedError = $e->getMessage();
            
            if ($controller->hasErrorHandler()) {
                $treatedError = $controller->handleError($e);
            }

            echo is_array($treatedError) ? json_encode($treatedError) : $treatedError;
        }
    }
}
