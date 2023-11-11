<?php

require("vendor/autoload.php");

define("MAIN_DIR", __DIR__.'/');
define("SITE_URL", "http://localhost:8080/");
define("FRONT_URL", "http://localhost:8084/");

define("DB_DATABASE", "users_db");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "secret");
define("DB_PORT", 3306);
define("DB_HOST", "users_database");

define("NOTIFICATIONS_HOST", "notifications_rabbitmq");
define("NOTIFICATIONS_EMAIL_QUEUE", "email_queue");
define("NOTIFICATIONS_PORT", 5672);
define("NOTIFICATIONS_USER", "user1");
define("NOTIFICATIONS_PASSWORD", "test12");

spl_autoload_register(function($class) {
    $class = str_replace("\\","/", $class);
    if(!file_exists(MAIN_DIR.'src/' . $class . '.php'))
        return;
    include MAIN_DIR.'src/' . $class . '.php';
});