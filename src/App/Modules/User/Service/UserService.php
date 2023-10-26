<?php

namespace App\Modules\User\Service;

use App\Model\Contact;
use App\Core\Model\User;
use Framework\Singleton\Page\Page;
use Framework\Singleton\Router\Router;

class UserService {
    public function __construct()
    {
        
    }

    public function findById(string $id): User {
        $user = User::find($id);
        if(!$user) {
            throw new \Exception("Usuário não encontrado");
        }

        return $user;
    }
}