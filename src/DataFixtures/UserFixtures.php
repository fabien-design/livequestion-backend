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
    ) {}
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
            'avatar' => "https://img.freepik.com/photos-gratuite/avatar-androgyne-personne-queer-non-binaire_23-2151100270.jpg?size=338&ext=jpg&ga=GA1.1.2008272138.1724630400&semt=ais_hybrid"
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
        ],
        [
            'username' => 'Alice Wonderland',
            'email' => 'alice.wonderland@example.com',
            'password' => 'alice123',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Sherlock Holmes',
            'email' => 'sherlock.holmes@example.com',
            'password' => 'detective',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Darth Vader',
            'email' => 'darth.vader@example.com',
            'password' => 'theforce',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Homer Simpson',
            'email' => 'homer.simpson@example.com',
            'password' => 'donuts',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Indiana Jones',
            'email' => 'indiana.jones@example.com',
            'password' => 'adventure',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Lara Croft',
            'email' => 'lara.croft@example.com',
            'password' => 'tombraider',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Neo Matrix',
            'email' => 'neo.matrix@example.com',
            'password' => 'matrix',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Hermione Granger',
            'email' => 'hermione.granger@example.com',
            'password' => 'magic',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Tony Stark',
            'email' => 'tony.stark@example.com',
            'password' => 'ironman',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Bruce Wayne',
            'email' => 'bruce.wayne@example.com',
            'password' => 'batman',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Frodo Baggins',
            'email' => 'frodo.baggins@example.com',
            'password' => 'thering',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Walter White',
            'email' => 'walter.white@example.com',
            'password' => 'heisenberg',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Luke Skywalker',
            'email' => 'luke.skywalker@example.com',
            'password' => 'jedi',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Rick Grimes',
            'email' => 'rick.grimes@example.com',
            'password' => 'twd',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Bilbo Baggins',
            'email' => 'bilbo.baggins@example.com',
            'password' => 'hobbit',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'James Bond',
            'email' => 'james.bond@example.com',
            'password' => '007',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Gordon Freeman',
            'email' => 'gordon.freeman@example.com',
            'password' => 'halflife',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Mario Bros',
            'email' => 'mario.bros@example.com',
            'password' => 'nintendo',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Jon Snow',
            'email' => 'jon.snow@example.com',
            'password' => 'winteriscoming',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Leia Organa',
            'email' => 'leia.organa@example.com',
            'password' => 'rebel',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Winston Smith',
            'email' => 'winston.smith@example.com',
            'password' => '1984',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Katniss Everdeen',
            'email' => 'katniss.everdeen@example.com',
            'password' => 'mockingjay',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Ellen Ripley',
            'email' => 'ellen.ripley@example.com',
            'password' => 'alien',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Trinity Matrix',
            'email' => 'trinity.matrix@example.com',
            'password' => 'matrix',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Marty McFly',
            'email' => 'marty.mcfly@example.com',
            'password' => 'bttf',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Yoda Jedi',
            'email' => 'yoda.jedi@example.com',
            'password' => 'force',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Gandalf Grey',
            'email' => 'gandalf.grey@example.com',
            'password' => 'wizard',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Vito Corleone',
            'email' => 'vito.corleone@example.com',
            'password' => 'godfather',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Tony Montana',
            'email' => 'tony.montana@example.com',
            'password' => 'scarface',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Jack Sparrow',
            'email' => 'jack.sparrow@example.com',
            'password' => 'pirate',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Lisbeth Salander',
            'email' => 'lisbeth.salander@example.com',
            'password' => 'dragon',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'John Wick',
            'email' => 'john.wick@example.com',
            'password' => 'revenge',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'The Joker',
            'email' => 'joker@example.com',
            'password' => 'chaos',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Dracula Count',
            'email' => 'dracula.count@example.com',
            'password' => 'vampire',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Albus Dumbledore',
            'email' => 'albus.dumbledore@example.com',
            'password' => 'hogwarts',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Sarah Connor',
            'email' => 'sarah.connor@example.com',
            'password' => 'terminator',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Spock Vulcan',
            'email' => 'spock.vulcan@example.com',
            'password' => 'startrek',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'James Kirk',
            'email' => 'james.kirk@example.com',
            'password' => 'enterprise',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Dexter Morgan',
            'email' => 'dexter.morgan@example.com',
            'password' => 'serial',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Tyler Durden',
            'email' => 'tyler.durden@example.com',
            'password' => 'fightclub',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Han Solo',
            'email' => 'han.solo@example.com',
            'password' => 'falcon',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Maximus Decimus',
            'email' => 'maximus.decimus@example.com',
            'password' => 'gladiator',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Gollum Smeagol',
            'email' => 'gollum.smeagol@example.com',
            'password' => 'precious',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Dr. House',
            'email' => 'dr.house@example.com',
            'password' => 'puzzle',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Michael Corleone',
            'email' => 'michael.corleone@example.com',
            'password' => 'godfather',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Ferris Bueller',
            'email' => 'ferris.bueller@example.com',
            'password' => 'dayoff',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Ethan Hunt',
            'email' => 'ethan.hunt@example.com',
            'password' => 'mission',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Michael Scofield',
            'email' => 'michael.scofield@example.com',
            'password' => 'prisonbreak',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'username' => 'Neo Anderson',
            'email' => 'neo.anderson@example.com',
            'password' => 'matrix',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
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
            $this->addReference(self::REFERENCE_IDENTIFIER . $appUser['username'], $user);
        }
        $manager->flush();
    }
}
