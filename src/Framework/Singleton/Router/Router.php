<?php

namespace Framework\Singleton\Router;

use Closure;
use Exception;
use Framework\Factory\ControllerFactory;
use Framework\Singleton\Singleton;

const ROUTE_NOT_FOUND_REDIRECT = 12;
const ROUTE_NOT_FOUND_BUT_DISPLAY_THE_ERROR = 13;

class Router implements Singleton
{
    private static $instance;
    private array $routes;

    private ControllerFactory $controllerFactory;

    public function __construct()
    {
        $this->createDefaultRoutes();
        $this->controllerFactory = new ControllerFactory();
    }

    private function createDefaultRoutes()
    {
        $this->routes[] = new Route("error/404", HttpMethods::GET, HttpDefaultRouteNames::NOT_FOUND, function () {
            return "404 Not Found";
        }, HttpDefaultCodes::NOT_FOUND);
        $this->routes[] = new Route("error/400", HttpMethods::GET, HttpDefaultRouteNames::BAD_REQUEST, function () {
            return "400 Bad Request";
        }, HttpDefaultCodes::BAD_REQUEST);
        $this->routes[] = new Route("error/401", HttpMethods::GET, HttpDefaultRouteNames::UNAUTHORIZED, function () {
            return "401 Unauthorized";
        }, HttpDefaultCodes::UNAUTHORIZED);
    }
    public static function get(): Router
    {
        if (self::$instance === null)
            self::$instance = new Router();
        return self::$instance;
    }

    public function addGet(string $url, string|Closure $action, string $name, int $code = HttpDefaultCodes::SUCCESS): void
    {
        $this->routes[] = new Route($url, HttpMethods::GET, $name, $action, $code);
    }
    public function addPost(string $url, string|Closure $action, string $name, int $code = HttpDefaultCodes::SUCCESS): void
    {
        $this->routes[] = new Route($url, HttpMethods::POST, $name, $action, $code);
    }
    public function addPut(string $url, string|Closure $action, string $name, int $code = HttpDefaultCodes::SUCCESS): void
    {
        $this->routes[] = new Route($url, HttpMethods::PUT, $name, $action, $code);
    }

    public function addDelete(string $url, string|Closure $action, string $name, int $code = HttpDefaultCodes::SUCCESS): void
    {
        $this->routes[] = new Route($url, HttpMethods::DELETE, $name, $action, $code);
    }

    public function route($routeName, $params = []): string
    {
        try {
            return str_replace(
                [":/"],
                "://",
                str_replace(
                    ["//"],
                    "/",
                    SITE_URL . $this->detectRouteByName($routeName)->getUrl()
                )
            ) . $this->paramsQuery($params);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), ROUTE_NOT_FOUND_BUT_DISPLAY_THE_ERROR);
        }
    }

    public function redirect(string $routeName, array $params = []): void
    {
        $route = $this->detectRouteByName($routeName);
        header(sprintf("HTTP/1.1 %s", HttpDefaultHeaders::getHeader($route->getCode())));
        header("Location: " . SITE_URL . $route->getUrl() . "") . $this->paramsQuery($params);
    }


    public function getHttpMethod(): string
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    private function paramsQuery(array $params): string
    {
        $paramsQuery = "";
        if (!empty($params)) {
            $paramsQuery = "?";
            $it = 0;
            foreach ($params as $paramName => $paramValue)
                $paramsQuery .= $paramName . "=" . $paramValue . (++$it < (count($params) - 1));
        }

        return $paramsQuery;
    }
    private function detectRouteByName(string $routeName): Route
    {
        $routeFound = null;
        foreach (self::get()->routes as $route) {
            if ($route->getName() == $routeName && $route->getHttpMethod() == self::get()->getHttpMethod()) {
                $routeFound = $route;
            }
        }
        if (!$routeFound) {
            throw new Exception("Router not found", ROUTE_NOT_FOUND_REDIRECT);
        }

        return $routeFound;
    }

    private function detectRouteByUrl(string $routeUrl): Route
    {
        $routeFound = null;
        foreach (self::get()->routes as $route) {
            $urlMatches = str_replace(['/', "http:", "https:"], "", $route->getUrl()) ==
                explode("?", str_replace(["/", "http:", "https:"], '', $routeUrl))[0];

            if ($urlMatches && $route->getHttpMethod() == self::get()->getHttpMethod()) {
                $routeFound = $route;
            }
        }

        if (!$routeFound) {
            throw new Exception("Router not found", ROUTE_NOT_FOUND_REDIRECT);
        }

        return $routeFound;
    }

    public function makeActionByUrl(string $url): void
    {
        try {
            $route = self::get()->detectRouteByUrl($url);

            if (is_callable($route->getAction())) {
                echo $route->getAction()();
                return;
            }

            self::get()->callRouteActionByParsingString($route);
        } catch (Exception $e) {
            if ($e->getCode() == ROUTE_NOT_FOUND_REDIRECT) {
                self::get()->redirect(HttpDefaultRouteNames::NOT_FOUND);
            } else {
                echo $e->getMessage();
            }
        }
    }

    private function callRouteActionByParsingString(Route $route): void
    {
        $controller = $this->controllerFactory->makeFromString(explode("@", $route->getAction())[0]);
        $methodName = explode("@", $route->getAction())[1];

        echo $controller->$methodName;
    }
}
