<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

       /**
        * @return Category[] Returns an array of Category objects
        */
    //    public function findAll(): array
    //    {
    //         $qb = $this->createQueryBuilder('c')
    //            ->orderBy('c.id', 'ASC');
    //         $result = $qb->getQuery()->getResult();
    //         $categories = [];
    //         foreach ($result as $category) {
    //             $categories[] = [
    //                 'id' => $category->getId(),
    //                 'name' => $category->getName(),
    //             ];
    //         }
    //         return $categories;
    //    }

    //    public function findOneBySomeField($value): ?Categories
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
