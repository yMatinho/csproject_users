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
        $user->username = $dto->username;
        $user->first_name = $dto->first_name;
        $user->last_name = $dto->last_name;
        $user->email = $dto->email;
        $user->password = md5($dto->password);
        $user->save();

        return $user;
    }

    public function update(Model $user, object $dto): User
    {
        $user->first_name = isset($dto->first_name) ? $dto->first_name : $user->first_name;
        $user->last_name = isset($dto->last_name) ? $dto->last_name : $user->last_name;
        $user->verified_at = isset($dto->verified_at) ? $dto->verified_at : $user->verified_at;
        $user->password = isset($dto->password) ? md5($dto->password) : $user->password;
        $user->save();

        return $user;
    }

    public function delete(Model $user): bool
    {
        User::delete($user->id);

        return true;
    }
}
