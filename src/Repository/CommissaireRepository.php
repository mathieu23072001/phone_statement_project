<?php

namespace App\Repository;

use App\Entity\Commissaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commissaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commissaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commissaire[]    findAll()
 * @method Commissaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommissaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commissaire::class);
    }

    // /**
    //  * @return Commissaire[] Returns an array of Commissaire objects
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
    public function findOneBySomeField($value): ?Commissaire
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
