<?php

namespace App\Modules\User\DTO\Request;

use Framework\Request\Request;

class UserUpdateRequest
{

    public function __construct(
        private int $userId,
        private ?string $password,
        private ?string $firstName,
        private ?string $lastName
    ) {
    }

    public static function fromRequest(Request $data): UserUpdateRequest
    {
        return new UserUpdateRequest(
            $data->id,
            $data->password,
            $data->firstName,
            $data->lastName
        );
    }

    public function toQueryFormat(): object {
        return (object)[
            "password"=> $this->password,
            "first_name"=> $this->firstName,
            "last_name"=> $this->lastName
        ];
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
}
