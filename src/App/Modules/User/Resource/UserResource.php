<?php

namespace App\Modules\User\Resource;

use Framework\Response\JsonResource;

class UserResource implements JsonResource
{

    public function __construct()
    {
    }

    public function exportFromArray(array $data): array
    {
        return [
            "id"=> isset($data["id"]) ? $data["id"] : null,
            "username"=> $data["username"],
            "email"=> $data["email"],
            "firstName"=> $data["first_name"],
            "lastName"=> $data["last_name"],
        ];
    }
}
