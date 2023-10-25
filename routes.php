<?php

use Framework\Singleton\Router\Router;

Router::get()->addGet("/user/find", "App\Modules\User\Controller\UserController@find", 'user.find');
