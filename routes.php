<?php

use Framework\Singleton\Router\Router;

Router::get()->addGet("/user/findAll", "App\Modules\User\Controller\UserController@findAll", 'user.findAll');
Router::get()->addGet("/user", "App\Modules\User\Controller\UserController@find", 'user.find');
Router::get()->addPost("/user/findByCredentials", "App\Modules\User\Controller\UserController@findByCredentials", 'user.findByCredentials');
Router::get()->addPost("/user", "App\Modules\User\Controller\UserController@create", 'user.create');
Router::get()->addPut("/user", "App\Modules\User\Controller\UserController@update", 'user.update');
Router::get()->addDelete("/user", "App\Modules\User\Controller\UserController@delete", 'user.delete');

Router::get()->addPost(
    "/emailVerification/send",
    "App\Modules\EmailVerification\Controller\EmailVerificationController@send",
    'emailVerification.send'
);

Router::get()->addPut(
    "/emailVerification/verify",
    "App\Modules\EmailVerification\Controller\EmailVerificationController@verify",
    'emailVerification.verify'
);
