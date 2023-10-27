<?php

namespace App\Modules\User\Service;

use App\Model\Contact;
use App\Core\Model\User;
use App\Modules\User\DTO\Request\UserCreationRequest;
use Framework\Exception\HttpException;
use Framework\Singleton\Page\Page;
use Framework\Singleton\Router\Router;

class UserService {
    public function __construct()
    {
        
    }

    public function findById(string $id): User {
        $user = User::find($id);
        if($user->isEmpty()) {
            throw new HttpException("Usuário não encontrado");
        }

        return $user;
    }

    public function create(UserCreationRequest $dto): User {
        $user = new User();
        $user->username = $dto->getUsername();
        $user->first_name = $dto->getFirstName();
        $user->last_name = $dto->getLastName();
        $user->email = $dto->getEmail();
        $user->password = md5($dto->getPassword());
        $user->save();

        return $user;
    }
}