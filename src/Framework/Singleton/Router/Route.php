<?php

namespace Framework\Singleton\Router;

use Closure;

class Route
{
    public function __construct(
        private string $url,
        private string $httpMethod,
        private string $name,
        private string|Closure $action,
        private int $code
    ) {
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getHttpMethod(): string {
        return $this->httpMethod;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getAction(): string|Closure {
        return $this->action;
    }

    public function getCode(): int {
        return $this->code;
    }
}
