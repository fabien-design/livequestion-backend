<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {}
    public const REFERENCE_IDENTIFIER = 'user_';
    public const USERS = [
        [
            'fake_id' => '1',
            'username' => 'Paax',
            'email' => 'admin@example.com',
            'password' => 'livequestion',
            'role' => 'ROLE_ADMIN',
            'avatar' => '11'
        ],
        [
            'fake_id' => '2',
            'username' => 'Test',
            'email' => 'test@example.com',
            'password' => 'test',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '3',
            'username' => 'Jean',
            'email' => 'jean@example.com',
            'password' => 'jean',
            'role' => 'ROLE_USER',
            'avatar' => "12"
        ],
        [
            'fake_id' => '4',
            'username' => 'Albator',
            'email' => 'albator@example.com',
            'password' => 'albator',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '5',
            'username' => 'TomSawyer',
            'email' => 'tomsawyer@example.com',
            'password' => 'tomsawyer',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '6',
            'username' => 'Pinocchio',
            'email' => 'pinocchio@example.com',
            'password' => 'pinocchio',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '7',
            'username' => 'PeterPan',
            'email' => 'peterpan@example.com',
            'password' => 'peterpan',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '8',
            'username' => 'Alice Wonderland',
            'email' => 'alice.wonderland@example.com',
            'password' => 'alice123',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '9',
            'username' => 'Sherlock Holmes',
            'email' => 'sherlock.holmes@example.com',
            'password' => 'detective',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '10',
            'username' => 'Darth Vader',
            'email' => 'darth.vader@example.com',
            'password' => 'theforce',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '11',
            'username' => 'Homer Simpson',
            'email' => 'homer.simpson@example.com',
            'password' => 'donuts',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '12',
            'username' => 'Indiana Jones',
            'email' => 'indiana.jones@example.com',
            'password' => 'adventure',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '13',
            'username' => 'Lara Croft',
            'email' => 'lara.croft@example.com',
            'password' => 'tombraider',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '14',
            'username' => 'Neo Matrix',
            'email' => 'neo.matrix@example.com',
            'password' => 'matrix',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '15',
            'username' => 'Hermione Granger',
            'email' => 'hermione.granger@example.com',
            'password' => 'magic',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '16',
            'username' => 'Tony Stark',
            'email' => 'tony.stark@example.com',
            'password' => 'ironman',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '17',
            'username' => 'Bruce Wayne',
            'email' => 'bruce.wayne@example.com',
            'password' => 'batman',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '18',
            'username' => 'Frodo Baggins',
            'email' => 'frodo.baggins@example.com',
            'password' => 'thering',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '19',
            'username' => 'Walter White',
            'email' => 'walter.white@example.com',
            'password' => 'heisenberg',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '20',
            'username' => 'Luke Skywalker',
            'email' => 'luke.skywalker@example.com',
            'password' => 'jedi',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '21',
            'username' => 'Rick Grimes',
            'email' => 'rick.grimes@example.com',
            'password' => 'twd',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '22',
            'username' => 'Bilbo Baggins',
            'email' => 'bilbo.baggins@example.com',
            'password' => 'hobbit',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '23',
            'username' => 'James Bond',
            'email' => 'james.bond@example.com',
            'password' => '007',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '24',
            'username' => 'Gordon Freeman',
            'email' => 'gordon.freeman@example.com',
            'password' => 'halflife',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '25',
            'username' => 'Mario Bros',
            'email' => 'mario.bros@example.com',
            'password' => 'nintendo',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '26',
            'username' => 'Jon Snow',
            'email' => 'jon.snow@example.com',
            'password' => 'winteriscoming',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '27',
            'username' => 'Leia Organa',
            'email' => 'leia.organa@example.com',
            'password' => 'rebel',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '28',
            'username' => 'Winston Smith',
            'email' => 'winston.smith@example.com',
            'password' => '1984',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '29',
            'username' => 'Katniss Everdeen',
            'email' => 'katniss.everdeen@example.com',
            'password' => 'mockingjay',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '30',
            'username' => 'Ellen Ripley',
            'email' => 'ellen.ripley@example.com',
            'password' => 'alien',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '31',
            'username' => 'Trinity Matrix',
            'email' => 'trinity.matrix@example.com',
            'password' => 'matrix',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '32',
            'username' => 'Marty McFly',
            'email' => 'marty.mcfly@example.com',
            'password' => 'bttf',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '33',
            'username' => 'Samus Aran',
            'email' => 'samus.aran@example.com',
            'password' => 'metroid',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '34',
            'username' => 'T800',
            'email' => 't800@example.com',
            'password' => 'terminator',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '35',
            'username' => 'John Connor',
            'email' => 'john.connor@example.com',
            'password' => 'resistance',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '36',
            'username' => 'Ethan Hunt',
            'email' => 'ethan.hunt@example.com',
            'password' => 'missionimpossible',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '37',
            'username' => 'Han Solo',
            'email' => 'han.solo@example.com',
            'password' => 'millenniumfalcon',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '38',
            'username' => 'Gandalf',
            'email' => 'gandalf@example.com',
            'password' => 'youcannotpass',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '39',
            'username' => 'Dr. Emmett Brown',
            'email' => 'emmett.brown@example.com',
            'password' => 'fluxcapacitor',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '40',
            'username' => 'Clarice Starling',
            'email' => 'clarice.starling@example.com',
            'password' => 'hannibal',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '41',
            'username' => 'Atticus Finch',
            'email' => 'atticus.finch@example.com',
            'password' => 'tokillamockingbird',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '42',
            'username' => 'Vito Corleone',
            'email' => 'vito.corleone@example.com',
            'password' => 'godfather',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '43',
            'username' => 'Forrest Gump',
            'email' => 'forrest.gump@example.com',
            'password' => 'boxofchocolates',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '44',
            'username' => 'Gollum',
            'email' => 'gollum@example.com',
            'password' => 'myprecious',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '45',
            'username' => 'Scarlett O\'Hara',
            'email' => 'scarlett.ohara@example.com',
            'password' => 'gonewiththewind',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '46',
            'username' => 'Dexter Morgan',
            'email' => 'dexter.morgan@example.com',
            'password' => 'darkpassenger',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '47',
            'username' => 'Walter Mitty',
            'email' => 'walter.mitty@example.com',
            'password' => 'daydream',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '48',
            'username' => 'Maximus Decimus',
            'email' => 'maximus.decimus@example.com',
            'password' => 'gladiator',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '49',
            'username' => 'Tyler Durden',
            'email' => 'tyler.durden@example.com',
            'password' => 'fightclub',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '50',
            'username' => 'Sarah Connor',
            'email' => 'sarah.connor@example.com',
            'password' => 'resistance',
            'role' => 'ROLE_USER',
            'avatar' => null
        ],
        [
            'fake_id' => '51',
            'username' => 'Harry Potter',
            'email' => 'harry.potter@example.com',
            'password' => 'wizard',
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
                ->setPassword($this->passwordHasher->hashPassword($user, $appUser['password']));
            if($appUser['avatar'] !== null){
                $user->setAvatar($this->getReference(ImagesFixtures::REFERENCE_IDENTIFIER .$appUser['avatar']));
            }

            $manager->persist($user);
            $this->addReference(self::REFERENCE_IDENTIFIER . $appUser['fake_id'], $user);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ImagesFixtures::class,
        ];
    }
}
