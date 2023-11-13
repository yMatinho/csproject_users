<?php

namespace App\Modules\EmailVerification\Resource\Endpoint;

use Framework\Response\JsonResource;

class VerifyResource extends JsonResource
{

    public function __construct()
    {
    }

    public function exportFromArray(array $data): array
    {
        return [
            "status"=> true,
            "message"=>$data["message"]
        ];
    }
}
