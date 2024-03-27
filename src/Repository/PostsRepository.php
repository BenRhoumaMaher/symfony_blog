<?php

/**
 * PostsRepository.php
 *
 * This file contains the definition of the AdminsRepository class
 * , which is used to manage Admins entities.
 *
 * @category Repositories
 * @package  App\Repository
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Repository;

use App\Entity\Posts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository class for managing Posts entities.
 *
 * @extends ServiceEntityRepository<Posts>
 *
 * @method   Posts|null find($id, $lockMode = null, $lockVersion = null)
 * @method   Posts|null findOneBy(array $criteria, array $orderBy = null)
 * @method   Posts[]    findAll()
 * @method   Posts[]
 * @category Repositories
 * @package  App\Repository\AdminsRepository
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostsRepository extends ServiceEntityRepository
{
    /**
     * PostsRepository constructor.
     *
     * @param ManagerRegistry $registry The registry service for managing entity managers.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posts::class);
    }

    /**
     * Find a post by a given post title.
     *
     * @param string $search The post title.
     *
     * @return int Number of posts in the given category.
     */
    public function findByTitle($search)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.title LIKE :search')
            ->setParameter('search', "%$search%")
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Posts[] Returns an array of Posts objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Posts
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
