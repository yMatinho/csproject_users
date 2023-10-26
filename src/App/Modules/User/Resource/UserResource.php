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
            "id"=> $data["id"],
        ];
    }
}
