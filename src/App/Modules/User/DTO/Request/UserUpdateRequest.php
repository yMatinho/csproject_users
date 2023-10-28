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
            $data->userId,
            $data->password,
            $data->firstName,
            $data->lastName
        );
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
