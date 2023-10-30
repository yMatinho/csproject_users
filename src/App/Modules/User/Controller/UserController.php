<?php

namespace App\Modules\User\Controller;

use App\Core\ErrorHandler\JsonHandler;
use App\Model\Contact;
use App\Modules\User\DTO\Request\UserCreationRequest;
use App\Modules\User\DTO\Request\UserUpdateRequest;
use App\Modules\User\Resource\Endpoint\CreateResource;
use App\Modules\User\Resource\Endpoint\DeleteResource;
use App\Modules\User\Resource\Endpoint\FindAllResource;
use App\Modules\User\Resource\Endpoint\FindResource;
use App\Modules\User\Resource\Endpoint\UpdateResource;
use App\Modules\User\Resource\UserResource;
use App\Modules\User\Service\UserService;
use Framework\Controller\Controller;
use Framework\Request\Request;
use Framework\Response\JsonResource;
use Framework\Singleton\Page\Page;
use Framework\Singleton\Router\Router;

class UserController extends Controller
{

    private readonly UserService $userService;
    private readonly JsonResource $userResource;
    private readonly JsonResource $createResource;
    private readonly JsonResource $updateResource;
    private readonly JsonResource $deleteResource;
    private readonly JsonResource $findResource;
    private readonly JsonResource $findAllResource;
    public function __construct()
    {
        $this->userService = new UserService();
        $this->userResource = new UserResource();
        $this->findResource = new FindResource();
        $this->findAllResource = new FindAllResource();
        $this->createResource = new CreateResource();
        $this->updateResource = new UpdateResource();
        $this->deleteResource = new DeleteResource();
        $this->errorHandler = new JsonHandler();
    }

    public function findAll(Request $request): array
    {
        return $this->findAllResource->exportFromArray([
            "users" => $this->userResource->exportFromCollection($this->userService->findAll())
        ]);
    }

    public function find(Request $request): array
    {
        return $this->findResource->exportFromArray([
            "user" => $this->userResource->exportFromModel($this->userService->findById($request->id))
        ]);
    }

    public function findByCredentials(Request $request): array
    {
        return $this->findResource->exportFromArray([
            "user" => $this->userResource->exportFromModel($this->userService->findByCredentials(
                $request->login,
                $request->password
            ))
        ]);
    }

    public function create(Request $request): array
    {
        $createdUser = $this->userService->create(
            UserCreationRequest::fromRequest($request)
        );

        return $this->createResource->exportFromArray([
            "user" => $this->userResource->exportFromModel($createdUser)
        ]);
    }

    public function update(Request $request): array
    {
        $createdUser = $this->userService->update(
            UserUpdateRequest::fromRequest($request)
        );

        return $this->updateResource->exportFromArray([
            "user" => $this->userResource->exportFromModel($createdUser)
        ]);
    }

    public function delete(Request $request): array
    {
        $this->userService->delete($request->id);

        return $this->deleteResource->exportFromArray(["message" => "Deletado com sucesso"]);
    }
}
