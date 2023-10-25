<?php

namespace Framework\Singleton\Asset;

use Framework\Factory\ViewFactory;
use Framework\Singleton\Singleton;
use Framework\View\View;

class Asset implements Singleton
{
    private static $instance;

    private function __construct()
    {
    }

    public static function get(): Asset
    {
        if (!self::$instance)
            self::$instance = new Asset();
        return self::$instance;
    }

    public function directory($dir): string
    {
        return MAIN_DIR . "public/" . $dir;
    }
    public function path($path): string
    {
        return SITE_URL . "public/$path";
    }
}
