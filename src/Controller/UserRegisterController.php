<?php

declare(strict_types=1);

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\DTO\UserRegisterInputDto;
use App\Entity\User;
use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;

class UserRegisterController extends AbstractController
{
    private UserFactory $userFactory;

    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    public function __invoke(Request $request, ValidatorInterface $validator): User
    {

       $data = $request->toArray();

        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        $registerDto = new UserRegisterInputDto($username, $password );

        $validator->validate($registerDto);

        return $this->userFactory->register($registerDto);
    }
}
