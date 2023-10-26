<?php

namespace Framework\Controller;

use Exception;
use Framework\ErrorHandler\ErrorHandler;

abstract class Controller {
    protected ErrorHandler $errorHandler;

    public function hasErrorHandler(): bool {
        return $this->errorHandler != null;
    }

    public function handleError(Exception $e): mixed {
        return $this->errorHandler->handle($e);
    }
}