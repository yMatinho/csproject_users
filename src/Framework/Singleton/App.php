<?php

namespace Framework\Singleton;

use Framework\Command\ApiExecutionCommand;
use Framework\Command\ExecutionCommand;
use Framework\Factory\ViewFactory;
use Framework\Singleton\Singleton;
use Framework\View\View;

class App implements Singleton
{
    private static $instance;

    private ExecutionCommand $command;

    private function __construct()
    {
    }

    public static function get(): App
    {
        if (!self::$instance)
            self::$instance = new App();
        return self::$instance;
    }

    public function executeApi() {
        header("Content-Type: application/json");
        
        $this->command = new ApiExecutionCommand($this->getBruteUrl());
        $this->command->execute();
    }

    private function getBruteUrl() : string {
        return str_replace(["/", "http:", "https:"], "", $_SERVER["REQUEST_URI"]);
    }
}
