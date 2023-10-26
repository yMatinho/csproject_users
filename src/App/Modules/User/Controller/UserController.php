<?php

namespace App\Modules\User\Controller;

use App\Model\Contact;
use App\Modules\User\Resource\Endpoint\FindResource;
use App\Modules\User\Resource\UserResource;
use App\Modules\User\Service\UserService;
use Framework\Controller\Controller;
use Framework\Singleton\Page\Page;
use Framework\Singleton\Router\Router;

class UserController extends Controller
{

    private readonly UserService $userService;
    private readonly UserResource $userResource;
    private readonly FindResource $findResource;
    public function __construct()
    {
        $this->userService = new UserService();
        $this->userResource = new UserResource();
        $this->findResource = new FindResource();
    }

    public function find()
    {
        return $this->findResource->exportFromArray(["user" => $this->userService->findById(1)]);
    }
}
