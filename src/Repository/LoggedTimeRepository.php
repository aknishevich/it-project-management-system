<?php

namespace App\Repository;

use App\Entity\LoggedTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LoggedTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoggedTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoggedTime[]    findAll()
 * @method LoggedTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoggedTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoggedTime::class);
    }

    // /**
    //  * @return LoggedTime[] Returns an array of LoggedTime objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LoggedTime
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
