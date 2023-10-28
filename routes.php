<?php

use Framework\Singleton\Router\Router;

Router::get()->addGet("/user/find", "App\Modules\User\Controller\UserController@find", 'user.find');
Router::get()->addPost("/user", "App\Modules\User\Controller\UserController@create", 'user.create');
Router::get()->addPut("/user", "App\Modules\User\Controller\UserController@update", 'user.update');
