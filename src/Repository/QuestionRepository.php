<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Question>
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Question::class);
    }

    public function PaginateQuestions(
        int $page,
        int $limit,
        string $orderBy = "DESC",
        string $sortBy = null,
        ?int $categoryId = null,
        ?int $authorId = null
    ): array {
        $qb = $this->createQueryBuilder('q')
            ->leftJoin('q.category', 'c')
            ->addSelect('c')
            ->leftJoin('q.images', 'i')
            ->addSelect('i')
            ->leftJoin('q.answers', 'a')
            ->addSelect('COUNT(a.id) AS HIDDEN answersCount')
            ->groupBy('q.id')
            ->orderBy($sortBy ? 'q.' . $sortBy : 'q.createdAt', $orderBy);
    
        // Application des filtres
        if ($categoryId) {
            $qb->andWhere('c.id = :categoryId')
                ->setParameter('categoryId', $categoryId);
        }
    
        if ($authorId) {
            $qb->andWhere('q.author = :authorId')
                ->setParameter('authorId', $authorId);
        }
    
        $pagination = $this->paginator->paginate(
            $qb->getQuery(),
            $page,
            $limit
        );
    
        // Transformation des résultats pour inclure le `answersCount` correctement
        $questions = [];
        foreach ($pagination as $question) {
            $questions[] = [
                'id' => $question->getId(),
                'title' => $question->getTitle(),
                'author' => [
                    'id' => $question->getAuthor()->getId(),
                    'username' => $question->getAuthor()->getUsername(),
                    'avatar' => $question->getAuthor()->getAvatar(),
                ],
                'images' => [
                    'id' => $question->getImages()->getId(),
                    'name' => $question->getImages()->getName(),
                ],
                'category' => [
                    'id' => $question->getCategory()->getId(),
                    'name' => $question->getCategory()->getName(),
                ],
                'createdAt' => $question->getCreatedAt(),
                'answersCount' => $question->getAnswers()->count(),
            ];
        }
    
        $pagination->setItems($questions);
    
        return [
            'items' => $questions,
            'pagination' => [
                'currentPage' => $page,
                'totalItems' => $pagination->getTotalItemCount(),
                'itemsPerPage' => $limit,
                'totalPages' => ceil($pagination->getTotalItemCount() / $limit),
            ],
        ];
    }

    public function findQuestionWithMostAnswersLastThreeDays(): ?array
    {
        $threeDaysAgo = new \DateTime('-3 days');

        $qb = $this->createQueryBuilder('q')
            ->leftJoin('q.category', 'c')
            ->addSelect('c')
            ->leftJoin('q.images', 'i')
            ->addSelect('i')
            ->leftJoin('q.answers', 'a')
            ->addSelect('COUNT(a.id) AS answersCount')
            ->where('q.createdAt >= :threeDaysAgo')
            ->setParameter('threeDaysAgo', $threeDaysAgo)
            ->groupBy('q.id')
            ->orderBy('answersCount', 'DESC')
            ->setMaxResults(1);

        $result =  $qb->getQuery()->getOneOrNullResult();

        if (!$result) {
            $qb = $this->createQueryBuilder('q')
                ->leftJoin('q.category', 'c')
                ->addSelect('c')
                ->leftJoin('q.images', 'i')
                ->addSelect('i')
                ->leftJoin('q.answers', 'a')
                ->addSelect('COUNT(a.id) AS answersCount')
                ->groupBy('q.id')
                ->orderBy('answersCount', 'DESC')
                ->setMaxResults(1);
            $result = $qb->getQuery()->getOneOrNullResult();
        }
        $question = $result[0];
        $question = [
            'id' => $question->getId(),
            'title' => $question->getTitle(),
            'author' => [
                'id' => $question->getAuthor()->getId(),
                'username' => $question->getAuthor()->getUsername(),
                'avatar' => $question->getAuthor()->getAvatar(),
            ],
            'images' => [
                'id' => $question->getImages()->getId(),
                'name' => $question->getImages()->getName(),
            ],
            'category' => [
                'id' => $question->getCategory()->getId(),
                'name' => $question->getCategory()->getName(),
            ],
            'createdAt' => $question->getCreatedAt(),
            'answersCount' => $question->getAnswers()->count(),
        ];

        return $question;
    }



    //    /**
    //     * @return Question[] Returns an array of Question objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Question
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
