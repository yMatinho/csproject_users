<?php

namespace App\Modules\User\Resource\Endpoint;

use Framework\Response\JsonResource;

class FindResource implements JsonResource
{

    public function __construct()
    {
    }

    public function exportFromArray(array $data): array
    {
        return [
            "status"=> true,
            "user"=>$data["user"]
        ];
    }
}
