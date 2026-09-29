<?php

namespace App\DTOs;

readonly class ResetPasswordData
{
    public function __construct(
        public string $email,
        public string $password,
        public string $token,
    ) {}
}
