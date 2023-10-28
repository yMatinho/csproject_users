<?php

namespace App\Modules\User\Service;

use App\Model\Contact;
use App\Core\Model\User;
use App\Core\Repository\Repository;
use App\Modules\User\DTO\Request\UserCreationRequest;
use App\Modules\User\DTO\Request\UserUpdateRequest;
use App\Modules\User\Repository\UserRepository;
use Framework\Exception\HttpException;
use Framework\Singleton\Page\Page;
use Framework\Singleton\Router\Router;

class UserService
{
    private Repository $repository;
    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function findById(string $id): User
    {
        $user = $this->repository->findById($id);
        if ($user->isEmpty()) {
            throw new HttpException("Usuário não encontrado");
        }

        return $user;
    }

    public function create(UserCreationRequest $dto): User
    {
        return $this->repository->create($dto);
    }

    public function update(UserUpdateRequest $dto): User
    {
        return $this->repository->update($this->findById($dto->getUserId()), $dto);
    }
}
