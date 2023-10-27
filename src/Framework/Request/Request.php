<?php

namespace Framework\Request;

abstract class Request {
    
    public function __construct(
        protected array $values
    ) {

    }

    public function __get(string $name) {
        return isset($this->values[$name]) ? $this->values[$name] : null;
    }

    public function getValues(): array {
        return $this->values;
    }
}