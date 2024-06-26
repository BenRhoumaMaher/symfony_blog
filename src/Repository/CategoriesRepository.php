<?php

/**
 * CategoriesRepository.php
 *
 * This file contains the definition of the CategoriesRepository class
 * , which is used to manage Categories entities.
 *
 * @category Repositories
 * @package  App\Repository
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Repository;

use App\Entity\Categories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository class for managing Categories entities.
 *
 * @extends ServiceEntityRepository<Categories>
 *
 * @method   Categories|null find($id, $lockMode = null, $lockVersion = null)
 * @method   Categories|null findOneBy(array $criteria, array $orderBy = null)
 * @method   Categories[]    findAll()
 * @method   Categories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @category Repositories
 * @package  App\Repository\AdminsRepository
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */
class CategoriesRepository extends ServiceEntityRepository
{
    /**
     * CategoriesRepository constructor.
     *
     * @param ManagerRegistry $registry The registry service for managing entity managers.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categories::class);
    }

    //    /**
    //     * @return Categories[] Returns an array of Categories objects
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
