<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{

    private const ANSWERS = [
        [
            "content" => "Je préfère Valorant car il a un style graphique plus coloré et des compétences uniques pour chaque agent, ce qui ajoute une dimension stratégique supplémentaire par rapport à CS2.",
            "author" => "1",
            "question" => "4"
        ],
        [
            "content" => "CS2 reste pour moi le choix numéro un. Il a une communauté bien établie et un gameplay plus centré sur le skill pur, sans les gadgets et pouvoirs de Valorant.",
            "author" => "2",
            "question" => "4"
        ],
        [
            "content" => "Valorant a l'avantage d'être plus accessible pour les nouveaux joueurs avec ses mécaniques de jeu modernes. Cependant, CS2 reste un classique indémodable pour les vétérans du FPS.",
            "author" => "3",
            "question" => "4"
        ],
        [
            "content" => "Les deux jeux sont bons, mais Valorant offre plus de diversité dans les stratégies grâce aux agents. Cela dit, si vous aimez la pureté du gunplay, CS2 est imbattable.",
            "author" => "4",
            "question" => "4"
        ],
        [
            "content" => "Valorant est un excellent jeu avec une communauté active, mais il n'a pas encore l'héritage de CS2. J'aime les deux, mais CS2 a une place spéciale pour son côté compétitif intense.",
            "author" => "5",
            "question" => "4"
        ],
        [
            "content" => "Valorant est jeu pour enfant, donc plus facile que cs",
            "author" => "6",
            "question" => "4"
        ],
        [
            "content" => "CS2 a un feeling plus réaliste et une meilleure optimisation. Valorant est sympa, mais il est trop orienté vers le fun et les effets visuels pour mon goût.",
            "author" => "2",
            "question" => "4"
        ],
        [
            "content" => "Deadpool et Wolverine, c'est top!!!!",
            "author" => "1",
            "question" => "6"
        ],
        [
            "content" => "Deadpool et Wolverine dans un même film, c'est juste épique ! L'humour décalé de Deadpool combiné au sérieux de Wolverine crée un duo parfait. J'ai adoré chaque minute.",
            "author" => "1",
            "question" => "6"
        ],
        [
            "content" => "Je trouve que le film est un bon divertissement, mais parfois l'humour de Deadpool prend un peu trop le dessus, au détriment de l'histoire plus profonde de Wolverine.",
            "author" => "6",
            "question" => "6"
        ],
        [
            "content" => "Ce film est un rêve devenu réalité pour tous les fans de comics. Les interactions entre Deadpool et Wolverine sont hilarantes, et l'action est au rendez-vous.",
            "author" => "5",
            "question" => "6"
        ],
        [
            "content" => "C'était cool de voir ces deux personnages ensemble, mais j'aurais aimé que l'histoire soit un peu plus sérieuse. Deadpool apporte beaucoup d'humour, mais Wolverine méritait un peu plus de gravité.",
            "author" => "10",
            "question" => "6"
        ],
        [
            "content" => "Un pur plaisir pour les fans des deux personnages ! Les scènes d'action sont incroyables, et l'humour est parfaitement dosé. Un must-see pour les amateurs de super-héros.",
            "author" => "50",
            "question" => "6"
        ],
        [
            "content" => "Personnellement, je préfère le foot. C'est un sport universel, accessible à tous, et il y a quelque chose de magique dans l'atmosphère d'un match de foot, que ce soit au stade ou devant la télé.",
            "author" => "1",
            "question" => "3"
        ],
        [
            "content" => "Le rugby a un esprit d'équipe et des valeurs de respect que je trouve admirables. C'est un sport où l'effort collectif prime, et j'aime la force et la stratégie qu'il demande.",
            "author" => "32",
            "question" => "3"
        ],
        [
            "content" => "Difficile de choisir entre les deux, mais je dirais que le rugby est plus intense et demande un engagement physique impressionnant. Le foot est plus populaire, mais le rugby a une âme différente.",
            "author" => "20",
            "question" => "3"
        ],
    ];
    

    public function load(ObjectManager $manager): void
    {
        foreach (self::ANSWERS as $answer) {
            $newAnswer = new Answer();
            $newAnswer->setContent($answer['content'])
                ->setAuthor($this->getReference(UserFixtures::REFERENCE_IDENTIFIER . $answer['author']))
                ->setQuestion($this->getReference(QuestionFixtures::REFERENCE_IDENTIFIER . $answer['question']));
            $manager->persist($newAnswer);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuestionFixtures::class,
            UserFixtures::class,
        ];
    }
}
