<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public const REFERENCE_IDENTIFIER = 'question_';

    private const QUESTIONS = [
        [
            'fake_id' => '1',
            'title' => 'Qui a inventé la machine à vapeur ?',
            'author' => '1',
            'images' => '1',
            'category' => 'Business',
        ],
        [
            'fake_id' => '2',
            'title' => 'Est-ce que Léon Marchand est meilleur que Phelps ??!!!',
            'author' => '2',
            'images' => '2',
            'category' => 'Sport',
        ],
        [
            'fake_id' => '3',
            'title' => 'Vous préférez le foot ou le rugby ?',
            'author' => '3',
            'images' => '3',
            'category' => 'Sport',
        ],
        [
            'fake_id' => '4',
            'title' => 'Est-ce que Valorant est mieux que CS2 ?',
            'author' => '4',
            'images' => '4',
            'category' => 'Jeux Videos',
        ],
        [
            'fake_id' => '5',
            'title' => 'D\'après vous, dans combien de temps la guerre en Ukraine va se finir ?',
            'author' => '5',
            'images' => '5',
            'category' => 'Politique',
        ],
        [
            'fake_id' => '6',
            'title' => 'Que pensez-vous du film Deadpool & Wolverine ?',
            'author' => '6',
            'images' => '6',
            'category' => 'Films',
        ],
        [
            'fake_id' => '7',
            'title' => 'Qui est le meilleur joueur de tennis de tous les temps ?',
            'author' => '7',
            'images' => '7',
            'category' => 'Sport',
        ],
        [
            'fake_id' => '8',
            'title' => 'Quelle est l’équipe favorite pour remporter la Coupe du Monde de rugby cette année ?',
            'author' => '8',
            'images' => '8',
            'category' => 'Sport',
        ],
        [
            'fake_id' => '9',
            'title' => 'Quel est le sport le plus difficile selon vous : la boxe ou le MMA ?',
            'author' => '9',
            'images' => '9',
            'category' => 'Sport',
        ],
        [
            'fake_id' => '10',
            'title' => 'Pensez-vous que Messi est supérieur à Ronaldo ?',
            'author' => '10',
            'images' => '10',
            'category' => 'Sport',
        ],

    ];


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::QUESTIONS as $question) {
            $newQuestion = new Question();
            $newQuestion->setTitle($question['title'])
                ->setAuthor($this->getReference(UserFixtures::REFERENCE_IDENTIFIER . $question['author']));
                if($question['images'] !== null){
                    $newQuestion->setImages($this->getReference(ImagesFixtures::REFERENCE_IDENTIFIER . $question['images']));
                }
               $newQuestion->setCategory($this->getReference(CategoryFixtures::REFERENCE_IDENTIFIER . $question['category']));
            $manager->persist($newQuestion);
            $this->addReference(QuestionFixtures::REFERENCE_IDENTIFIER. $question['fake_id'], $newQuestion);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ImagesFixtures::class,
            CategoryFixtures::class
        ];
    }
}
