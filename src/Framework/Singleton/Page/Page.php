<?php

namespace Framework\Singleton\Page;

use Framework\Factory\ViewFactory;
use Framework\Singleton\Singleton;
use Framework\View\View;

class Page implements Singleton
{
    private static $instance;

    private function __construct()
    {
    }

    public static function get(): Page
    {
        if (!self::$instance)
            self::$instance = new Page();
        return self::$instance;
    }

    public function loadTemplate(string $template, array $replacements): string
    {
        return (new ViewFactory($template, $replacements))->makeView()->html();
    }
    public function getView(string $template, array $replacements): View
    {
        return (new ViewFactory($template, $replacements))->makeView();
    }
}
