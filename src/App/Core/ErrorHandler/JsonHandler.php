<?php

namespace App\Core\ErrorHandler;

use Exception;
use Framework\ErrorHandler\ErrorHandler;

class JsonHandler extends ErrorHandler {
    public function __construct() {}

    public function handle(Exception $e): array {
        return [
            "status"=>false,
            "message"=>$e->getMessage(),
            "code"=>$e->getCode()
        ];
    }
}