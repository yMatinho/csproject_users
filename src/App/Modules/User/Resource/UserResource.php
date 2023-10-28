<?php

namespace App\Modules\User\Resource;

use Framework\Response\JsonResource;

class UserResource extends JsonResource
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
            "createdAt"=> isset($data["created_at"]) ? $data["created_at"] : null,
            "updatedAt"=> isset($data["updated_at"]) ? $data["updated_at"] : null,
        ];
    }
}
