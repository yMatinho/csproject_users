<?php

define("MAIN_DIR", __DIR__.'/');
define("SITE_URL", "http://localhost:8080/");

define("DB_DATABASE", "csproject_db");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "secret");
define("DB_HOST", "database");

spl_autoload_register(function($class) {
    $class = str_replace("\\","/", $class);
    if(!file_exists(MAIN_DIR.'src/' . $class . '.php'))
        return;
    include MAIN_DIR.'src/' . $class . '.php';
});