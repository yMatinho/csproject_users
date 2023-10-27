<?php

namespace App\Modules\User\Service;

use App\Model\Contact;
use App\Core\Model\User;
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

    public function create(array $data): User {
        $user = new User();
        $user->username = $data["username"];
        $user->first_name = $data["firstName"];
        $user->last_name = $data["lastName"];
        $user->email = $data["email"];
        $user->password = md5($data["password"]);
        $user->save();

        return $user;
    }
}