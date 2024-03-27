<?php

/**
 * Comments.php
 *
 * This file contains the definition of the CommentsRepository class
 * , which is used to manage Comments entities.
 *
 * @category Repositories
 * @package  App\Repository
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Repository;

use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository class for managing Comments entities.
 *
 * @extends ServiceEntityRepository<Comments>
 *
 * @method   Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method   Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method   Comments[]    findAll()
 * @method   Comments[]    findBy(array $criteria,
 * array $orderBy = null, $limit = null, $offset = null)
 * @category Repositories
 * @package  App\Repository
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */
class CommentsRepository extends ServiceEntityRepository
{
    /**
     * CommentsRepository constructor.
     *
     * @param ManagerRegistry $registry The registry service
     *                                  for managing entity managers.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comments::class);
    }

    //    /**
    //     * @return Comments[] Returns an array of Comments objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Comments
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
