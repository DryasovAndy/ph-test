<?php

declare(strict_types=1);

namespace App\Factory;

use App\DTO\UserRegisterInputDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Error;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    private EntityManagerInterface $em;

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
    }

    public function register(UserRegisterInputDto $userRegisterInputDto): User
    {
        $user = $this
            ->em
            ->getRepository(User::class)
            ->findOneBy(['username' => $userRegisterInputDto->getUsername()]);

        if ($user) {
            throw new Error('Username is unavailable');
        }

        $user = new User();
        $user->setUsername($userRegisterInputDto->getUsername());
        $user->setPassword($this->passwordHasher->hashPassword($user, $userRegisterInputDto->getPassword()));
        $user->setRoles(['ROLE_USER']);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
