<?php

namespace App\Modules\User\Repository;

use App\Core\Repository\Repository;
use App\Model\Contact;
use App\Core\Model\User;
use App\Modules\User\DTO\Request\UserCreationRequest;
use App\Modules\User\DTO\Request\UserUpdateRequest;
use Framework\Exception\HttpException;
use Framework\Model\Collection;
use Framework\Model\Model;
use Framework\Singleton\Page\Page;
use Framework\Singleton\Router\Router;

class UserRepository implements Repository
{
    public function __construct()
    {
    }

    public function findAll(): Collection
    {
        return User::all();
    }

    public function findById(int|string $id, bool $throwNotFoundException = false): User
    {
        return User::find($id, $throwNotFoundException);
    }

    public function findBy(array $comparisons, bool $throwNotFoundException = false): User
    {
        return User::findBy($comparisons, $throwNotFoundException);
    }

    public function create(object $dto): User
    {
        $user = new User();
        $user->username = $dto->getUsername();
        $user->first_name = $dto->getFirstName();
        $user->last_name = $dto->getLastName();
        $user->email = $dto->getEmail();
        $user->password = md5($dto->getPassword());
        $user->save();

        return $user;
    }

    public function update(Model $user, object $dto): User
    {
        $user->first_name = $dto->getFirstName() ?: $user->first_name;
        $user->last_name = $dto->getLastName() ?: $user->last_name;
        $user->password = $dto->getPassword() ? md5($dto->getPassword()) : $user->password;
        $user->save();

        return $user;
    }

    public function delete(Model $user): bool
    {
        User::delete($user->id);

        return true;
    }
}
