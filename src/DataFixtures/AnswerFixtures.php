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
        [
            "content" => "Je pense que les jeux vidéo peuvent effectivement être bénéfiques pour la santé mentale, surtout pour se détendre après une journée stressante. Cela permet de s'évader et de se plonger dans un autre univers.",
            "author" => "15",
            "question" => "20"
        ],
        [
            "content" => "Les jeux vidéo peuvent être un excellent moyen de réduire l'anxiété, notamment grâce à l'aspect immersif et la concentration qu'ils demandent. Cependant, il faut faire attention à ne pas en abuser.",
            "author" => "16",
            "question" => "20"
        ],
        [
            "content" => "Tout dépend du jeu et de l'usage que l'on en fait. Certains jeux peuvent stimuler l'esprit et aider à développer des compétences, tandis que d'autres peuvent parfois renforcer l'isolement si on y joue trop.",
            "author" => "17",
            "question" => "20"
        ],
        [
            "content" => "Pour moi, les jeux vidéo sont un excellent moyen de socialiser en ligne, surtout quand on joue avec des amis. Cela peut aider à lutter contre la solitude.",
            "author" => "18",
            "question" => "20"
        ],
        [
            "content" => "Je crois que les jeux vidéo peuvent être bénéfiques s'ils sont utilisés de manière équilibrée. Ils permettent de s'évader et d'oublier ses soucis, mais comme toute chose, ils doivent être pratiqués avec modération.",
            "author" => "20",
            "question" => "20"
        ],
        [
            "content" => "Les jeux vidéo peuvent stimuler la créativité et même aider à gérer le stress. Cela dit, il est essentiel de trouver un équilibre pour ne pas devenir dépendant.",
            "author" => "20",
            "question" => "20"
        ],
        [
            "content" => "Certaines études montrent que les jeux vidéo peuvent améliorer la concentration et réduire l'anxiété. Je suis d'accord avec ça, mais je pense qu'il est important de choisir des jeux qui correspondent à ces objectifs.",
            "author" => "21",
            "question" => "20"
        ],
        [
            "content" => "Les jeux vidéo peuvent offrir une forme de thérapie pour certaines personnes, surtout ceux qui permettent d'interagir avec d'autres joueurs et de créer des liens sociaux.",
            "author" => "22",
            "question" => "20"
        ],
        [
            "content" => "Personnellement, les jeux vidéo m'aident à me détendre et à évacuer le stress. Cela dit, je veille toujours à équilibrer mon temps de jeu avec d'autres activités.",
            "author" => "23",
            "question" => "20"
        ],
        [
            "content" => "Je crois fermement que les jeux vidéo peuvent avoir un impact positif sur la santé mentale, notamment en aidant à améliorer la résilience et la gestion du stress.",
            "author" => "24",
            "question" => "20"
        ],
        [
            "content" => "Je pense que les jeux vidéo peuvent effectivement être bénéfiques pour la santé mentale, surtout pour se détendre après une journée stressante. Cela permet de s'évader et de se plonger dans un autre univers.",
            "author" => "15",
            "question" => "20"
        ],
        [
            "content" => "Les jeux vidéo peuvent être un excellent moyen de réduire l'anxiété, notamment grâce à l'aspect immersif et la concentration qu'ils demandent. Cependant, il faut faire attention à ne pas en abuser.",
            "author" => "16",
            "question" => "20"
        ],
        [
            "content" => "Tout dépend du jeu et de l'usage que l'on en fait. Certains jeux peuvent stimuler l'esprit et aider à développer des compétences, tandis que d'autres peuvent parfois renforcer l'isolement si on y joue trop.",
            "author" => "17",
            "question" => "20"
        ],
        [
            "content" => "Pour moi, les jeux vidéo sont un excellent moyen de socialiser en ligne, surtout quand on joue avec des amis. Cela peut aider à lutter contre la solitude.",
            "author" => "18",
            "question" => "20"
        ],
        [
            "content" => "Je crois que les jeux vidéo peuvent être bénéfiques s'ils sont utilisés de manière équilibrée. Ils permettent de s'évader et d'oublier ses soucis, mais comme toute chose, ils doivent être pratiqués avec modération.",
            "author" => "19",
            "question" => "20"
        ],
        [
            "content" => "Les jeux vidéo peuvent stimuler la créativité et même aider à gérer le stress. Cela dit, il est essentiel de trouver un équilibre pour ne pas devenir dépendant.",
            "author" => "45",
            "question" => "20"
        ],
        [
            "content" => "Certaines études montrent que les jeux vidéo peuvent améliorer la concentration et réduire l'anxiété. Je suis d'accord avec ça, mais je pense qu'il est important de choisir des jeux qui correspondent à ces objectifs.",
            "author" => "21",
            "question" => "20"
        ],
        [
            "content" => "Les jeux vidéo peuvent offrir une forme de thérapie pour certaines personnes, surtout ceux qui permettent d'interagir avec d'autres joueurs et de créer des liens sociaux.",
            "author" => "22",
            "question" => "20"
        ],
        [
            "content" => "Personnellement, les jeux vidéo m'aident à me détendre et à évacuer le stress. Cela dit, je veille toujours à équilibrer mon temps de jeu avec d'autres activités.",
            "author" => "23",
            "question" => "20"
        ],
        [
            "content" => "Je crois fermement que les jeux vidéo peuvent avoir un impact positif sur la santé mentale, notamment en aidant à améliorer la résilience et la gestion du stress.",
            "author" => "24",
            "question" => "20"
        ],
        [
            "content" => "L'un des plus grands défis pour l'économie mondiale est certainement l'inflation, qui touche de nombreux pays et pèse sur le pouvoir d'achat des citoyens.",
            "author" => "15",
            "question" => "13"
        ],
        [
            "content" => "Je pense que les inégalités économiques croissantes entre les pays développés et les pays en développement représentent un défi majeur. Il devient de plus en plus difficile de réduire cet écart.",
            "author" => "22",
            "question" => "13"
        ],
        [
            "content" => "Le changement climatique est sans aucun doute un défi majeur. L'économie mondiale doit s'adapter à des pratiques plus durables, ce qui nécessite de gros investissements.",
            "author" => "35",
            "question" => "13"
        ],
        [
            "content" => "La volatilité des marchés financiers, exacerbée par les crises géopolitiques, est un défi de taille. Les fluctuations imprévisibles compliquent la planification à long terme pour les entreprises.",
            "author" => "27",
            "question" => "13"
        ],
        [
            "content" => "Le vieillissement de la population dans de nombreux pays développés pose un énorme défi. Cela affecte non seulement le marché du travail, mais aussi les systèmes de retraite et de santé.",
            "author" => "18",
            "question" => "13"
        ],
        [
            "content" => "La digitalisation rapide de l'économie mondiale crée des défis en termes de régulation et d'équité. Toutes les entreprises ne sont pas préparées pour cette transition.",
            "author" => "30",
            "question" => "13"
        ],
        [
            "content" => "La montée des tensions commerciales entre les grandes puissances économiques, comme les États-Unis et la Chine, est un facteur de risque important pour l'économie mondiale.",
            "author" => "24",
            "question" => "13"
        ],
        [
            "content" => "Le défi énergétique est crucial. La transition vers des énergies renouvelables doit se faire rapidement, mais cela implique des coûts énormes et des restructurations industrielles.",
            "author" => "39",
            "question" => "13"
        ],
        [
            "content" => "Les cybermenaces croissantes constituent un défi majeur pour l'économie mondiale. La sécurité des données et des transactions financières devient de plus en plus cruciale.",
            "author" => "16",
            "question" => "13"
        ],
        [
            "content" => "L'instabilité politique dans certaines régions du monde crée un environnement incertain pour les investissements, ce qui freine la croissance économique.",
            "author" => "42",
            "question" => "13"
        ],
        [
            "content" => "La gestion de la dette publique, particulièrement après la pandémie, est un défi énorme. De nombreux pays sont confrontés à des niveaux d'endettement sans précédent.",
            "author" => "33",
            "question" => "13"
        ],
        [
            "content" => "L'éducation et la formation pour préparer les travailleurs aux métiers du futur représentent un défi clé. L'économie mondiale change rapidement et le capital humain doit suivre.",
            "author" => "29",
            "question" => "13"
        ],
        [
            "content" => "L'accès inégal aux vaccins et aux soins de santé à l'échelle mondiale est un défi crucial pour l'économie. Sans une réponse globale, la reprise économique sera inégale.",
            "author" => "25",
            "question" => "13"
        ],
        [
            "content" => "La répartition des richesses reste un problème majeur. Si la concentration des richesses dans les mains de quelques-uns continue, cela pourrait mener à des troubles sociaux.",
            "author" => "46",
            "question" => "13"
        ]
        
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
