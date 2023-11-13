<?php

namespace App\Modules\User\DTO\Request;

use Framework\Request\Request;

class UserCreationRequest
{

    public function __construct(
        private string $username,
        private string $email,
        private string $password,
        private string $firstName,
        private string $lastName
    ) {
    }

    public static function fromRequest(Request $data): UserCreationRequest
    {
        return new UserCreationRequest(
            $data->username,
            $data->email,
            $data->password,
            $data->firstName,
            $data->lastName
        );
    }

    public function toQueryFormat(): object {
        return (object)[
            "username"=> $this->username,
            "email"=> $this->email,
            "password"=> $this->password,
            "first_name"=> $this->firstName,
            "last_name"=> $this->lastName
        ];
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }
    public function getLastName(): string
    {
        return $this->lastName;
    }
}
