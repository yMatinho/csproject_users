<?php

namespace App\Modules\User\Controller;

use App\Model\Contact;
use App\Modules\User\Service\UserService;
use Framework\Controller\Controller;
use Framework\Singleton\Page\Page;
use Framework\Singleton\Router\Router;

class UserController extends Controller {

    private readonly UserService $userService;
    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function find() {
        return $this->userService->findById(1);
    }
}