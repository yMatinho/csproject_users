<?php

namespace Framework\Command;

use Exception;
use Framework\Controller\Controller;
use Framework\Exception\HttpException;
use Framework\Factory\ApiRequestFactory;
use Framework\Factory\ControllerFactory;
use Framework\Factory\RequestFactory;
use Framework\Singleton\Router\HttpDefaultCodes;
use Framework\Singleton\Router\HttpDefaultHeaders;
use Framework\Singleton\Router\HttpDefaultRouteNames;
use Framework\Singleton\Router\Route;
use Framework\Singleton\Router\Router;

class ApiExecutionCommand extends ExecutionCommand
{

    private RequestFactory $apiRequestFactory;

    public function __construct(private readonly string $url)
    {
        parent::__construct();
        $this->apiRequestFactory = new ApiRequestFactory();
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
            $request = $this->apiRequestFactory->make();
            $result = $controller->$methodName($request);

            echo is_array($result) ? json_encode($result) : $result;
        } catch (Exception $e) {
            header(HttpDefaultHeaders::getHeader(HttpDefaultCodes::BAD_REQUEST));
            echo $this->treatedError($e, $controller);
        } catch(HttpException $e) {
            header(HttpDefaultHeaders::getHeader($e->getCode()));
            echo $this->treatedError($e, $controller);
        }
    }

    private function treatedError(Exception $e, Controller $controller): string
    {
        $treatedError = $e->getMessage();

        if ($controller->hasErrorHandler()) {
            $treatedError = $controller->handleError($e);
        }

        return is_array($treatedError) ? json_encode($treatedError) : $treatedError;
    }
}
