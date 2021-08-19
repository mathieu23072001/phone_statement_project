<?php

namespace App\Repository;

use App\Entity\CDS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CDS|null find($id, $lockMode = null, $lockVersion = null)
 * @method CDS|null findOneBy(array $criteria, array $orderBy = null)
 * @method CDS[]    findAll()
 * @method CDS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CDSRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CDS::class);
    }

    // /**
    //  * @return CDS[] Returns an array of CDS objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CDS
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
