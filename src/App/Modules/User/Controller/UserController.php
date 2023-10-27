<?php

namespace App\Modules\User\Controller;

use App\Core\ErrorHandler\JsonHandler;
use App\Model\Contact;
use App\Modules\User\DTO\Request\UserCreationRequest;
use App\Modules\User\Resource\Endpoint\CreateResource;
use App\Modules\User\Resource\Endpoint\FindResource;
use App\Modules\User\Resource\UserResource;
use App\Modules\User\Service\UserService;
use Framework\Controller\Controller;
use Framework\Response\JsonResource;
use Framework\Singleton\Page\Page;
use Framework\Singleton\Router\Router;

class UserController extends Controller
{

    private readonly UserService $userService;
    private readonly JsonResource $userResource;
    private readonly JsonResource $createResource;
    private readonly JsonResource $findResource;
    public function __construct()
    {
        $this->userService = new UserService();
        $this->userResource = new UserResource();
        $this->findResource = new FindResource();
        $this->createResource = new CreateResource();
        $this->errorHandler = new JsonHandler();
    }

    public function find()
    {
        return $this->findResource->exportFromArray([
            "user" => $this->userResource->exportFromModel($this->userService->findById(1))
        ]);
    }

    public function create()
    {
        $createdUser = $this->userService->create(
            UserCreationRequest::fromArray(json_decode(file_get_contents('php://input'), true))
        );

        return $this->createResource->exportFromArray([
            "user" => $this->userResource->exportFromModel($createdUser)
        ]);
    }
}
