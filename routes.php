<?php

use Framework\Singleton\Router\Router;

Router::get()->addGet("/", "App\Controller\SiteController@showHome", 'site.home');
