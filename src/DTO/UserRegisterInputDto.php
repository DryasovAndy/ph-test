<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserRegisterInputDto
{
    #[Assert\NotBlank]
    private ?string $username;

    #[Assert\NotBlank]
    private ?string $password;

    public function __construct(
        ?string $username,
        ?string $password
    ) {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
