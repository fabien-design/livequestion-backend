<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function loadUserByIdentifier(string $usernameOrEmail): ?User
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT u
                FROM App\Entity\User u
                WHERE u.username = :query
                OR u.email = :query'
        )
            ->setParameter('query', $usernameOrEmail)
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    public function findBestUsers(int $limit = null): array
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u', 'COUNT(q.id) AS HIDDEN questions_count')
            ->leftJoin('u.questions', 'q')
            ->groupBy('u.id')
            ->orderBy('questions_count', 'DESC')
            ->setMaxResults($limit);

        $users = $qb->getQuery()->getResult();

        $result = [];
        foreach ($users as $user) {
            $result[] = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'avatar' => $user->getAvatar(),
                'questions_count' => $user->getQuestions()->count(),
                'created_at' => $user->getCreatedAt(),
            ];
        }

        return $result;
    }

    public function PaginateUsers(
        int $page,
        int $limit,
        string $orderBy = "DESC",
    ): array {
        $qb = $this->createQueryBuilder('u')
            ->select('u', 'COUNT(q.id) AS HIDDEN questions_count')
            ->leftJoin('u.questions', 'q')
            ->groupBy('u.id')
            ->orderBy('questions_count', $orderBy);
    
    
        $pagination = $this->paginator->paginate(
            $qb->getQuery(),
            $page,
            $limit
        );
    
        // Transformation des résultats pour inclure le `answersCount` correctement
        $users = [];
        foreach ($pagination as $user) {
            $users[] = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'avatar' => $user->getAvatar(),
                'questions_count' => $user->getQuestions()->count(),
                'created_at' => $user->getCreatedAt(),
            ];
        }
    
        $pagination->setItems($users);
    
        return [
            'items' => $users,
            'pagination' => [
                'currentPage' => $page,
                'totalItems' => $pagination->getTotalItemCount(),
                'itemsPerPage' => $limit,
                'totalPages' => ceil($pagination->getTotalItemCount() / $limit),
            ],
        ];
    }
}
