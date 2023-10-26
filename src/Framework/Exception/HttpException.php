<?php

namespace Framework\Exception;

use Framework\Singleton\Router\HttpDefaultCodes;

class HttpException extends \Exception  {
    public function __construct($message = "", $httpCode = HttpDefaultCodes::BAD_REQUEST) {
        parent::__construct($message, $httpCode);
    }
}