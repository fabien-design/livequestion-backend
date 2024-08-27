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
    public const REFERENCE_IDENTIFIER = 'user_';
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
        ],
        [
            'username' => 'Jean',
            'email' => 'jean@example.com',
            'password' => 'jean',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Albator',
            'email' => 'albator@example.com',
            'password' => 'albator',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'TomSawyer',
            'email' => 'tomsawyer@example.com',
            'password' => 'tomsawyer',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Pinocchio',
            'email' => 'pinocchio@example.com',
            'password' => 'pinocchio',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'PeterPan',
            'email' => 'peterpan@example.com',
            'password' => 'peterpan',
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
            $this->addReference(self::REFERENCE_IDENTIFIER. $appUser['username'], $user);
        }
        $manager->flush();
    }
}
