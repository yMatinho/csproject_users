<?php

namespace Framework\ErrorHandler;

use Exception;

abstract class ErrorHandler {
    abstract public function handle(Exception $e): mixed;
}