<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public const USERS = [
        [
            'username' => 'Paax',
            'email' => 'admin@example.com',
            'password' => 'livequestion',
            'role' => 'ROLE_ADMIN',
            'avatar' => 'https://avatars.githubusercontent.com/u/60236223'
        ],
        [
            'username' => 'Test',
            'email' => 'test@example.com',
            'password' => 'test',
            'role' => 'ROLE_USER',
            'avatar' => null
        ]
    ];



    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $i => $appUser) {
            $user = new User();
            $user->setUsername($appUser['username'])
                ->setEmail($appUser['email'])
                ->setRoles([$appUser['role']])
                ->setPassword($this->passwordHasher->hashPassword($user, $appUser['password']))
                ->setAvatar($appUser['avatar']);

            $manager->persist($user);
        }
        $manager->flush();
    }
}
