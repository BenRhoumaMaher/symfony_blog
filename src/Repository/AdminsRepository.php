<?php
/**
 * AdminsRepository.php
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

use App\Entity\Admins;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository class for managing Admins entities.
 * 
 * @extends ServiceEntityRepository<Admins>
 *
 * @method   Admins|null find($id, $lockMode = null, $lockVersion = null)
 * @method   Admins|null findOneBy(array $criteria, array $orderBy = null)
 * @method   Admins[]    findAll()
 * @method   Admins[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @category Repositories
 * @package  App\Repository\AdminsRepository
 * @author   Maher Ben Rhouma <maherbenrhouma@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */
class AdminsRepository extends ServiceEntityRepository
{

    /**
     * AdminsRepository constructor.
     *
     * @param ManagerRegistry $registry The registry service for managing entity managers.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Admins::class);
    }

    //    /**
    //     * @return Admins[] Returns an array of Admins objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Admins
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
