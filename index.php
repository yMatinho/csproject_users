<?php

use Framework\Singleton\App;
use Framework\Singleton\Router\Router;

include("config.php");
include("routes.php");

App::get()->executeApi();
