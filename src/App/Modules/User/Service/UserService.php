<?php

namespace App\Modules\User\Service;

use App\Model\Contact;
use App\Core\Model\User;
use App\Core\Repository\Repository;
use App\Modules\User\DTO\Request\UserCreationRequest;
use App\Modules\User\DTO\Request\UserUpdateRequest;
use App\Modules\User\Repository\UserRepository;
use Framework\DB\Query\Clausure\WhereComparison;
use Framework\Exception\HttpException;
use Framework\Model\Collection;
use Framework\Singleton\Page\Page;
use Framework\Singleton\Router\Router;

class UserService
{
    private Repository $repository;
    public function __construct()
    {
        $this->repository = new UserRepository();
    }
    public function findByEmail(string $email): User
    {
        $user = $this->repository->findBy([
            new WhereComparison("email", "=", $email)
        ]);
        if ($user->isEmpty()) {
            throw new HttpException("Usuário não encontrado");
        }

        return $user;
    }

    public function findById(string $id): User
    {
        $user = $this->repository->findById($id);
        if ($user->isEmpty()) {
            throw new HttpException("Usuário não encontrado");
        }

        return $user;
    }

    public function findByCredentials(string $login, string $password): User
    {
        $user = $this->repository->findBy([
            new WhereComparison("email", "=", $login),
            new WhereComparison("password", "=", md5($password)),
        ]);
        $this->verifyFoundUser($user);

        return $user;
    }

    private function verifyFoundUser(User $user) {
        if ($user->isEmpty()) {
            throw new HttpException("Login inválido");
        }
        if(!$user->isVerified()) {
            throw new HttpException("Verifique seu email para continuar");
        }
    }

    public function findAll(): Collection
    {
        return $this->repository->findAll();
    }

    public function create(UserCreationRequest $dto): User
    {
        return $this->repository->create($dto->toQueryFormat());
    }

    public function update(UserUpdateRequest $dto): User
    {
        return $this->repository->update($this->findById($dto->getUserId()), $dto->toQueryFormat());
    }

    public function delete(int $id): void
    {
        $this->repository->delete($this->findById($id));
    }

    public function verify(int $id): void
    {
        $user = $this->findById($id);
        $this->repository->update($user, (object)[
            "verified_at" => date("Y-m-d H:i:s")
        ]);
    }
}
