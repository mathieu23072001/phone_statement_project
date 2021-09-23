<?php

namespace App\Repository;

use PDO;
use App\Entity\Appel;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Appel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appel[]    findAll()
 * @method Appel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appel::class);
    }

    // /**
    //  * @return Appel[] Returns an array of Appel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Appel
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function AppelByDate( $id ,$stringDate , $dateF){

       $query =  $this->createQueryBuilder('a');
       $query->where('a.date BETWEEN :stringDate AND :dateF');
       $query->andWhere('a.peronneOne =:id');
       $query->groupBy('a.personneTwo')
       ->setParameter('id', $id)
       ->setParameter('stringDate', $stringDate)
       ->setParameter('dateF', $dateF);
    
      ;
         return $query->getQuery()->getResult();
    }

    public function detailsAppel($em,$id1,$id2,$sens)
    {
        try {
            $sqlrech = " 
       

            SELECT DISTINCT count(a.sens_appel) as nbre
   
      from appel a  where  a.peronne_one_id = :r1  AND a.personne_two_id = :r2 AND sens_appel= :sens 
      
            
            
            ";
           
                      
            $stmt = $em->getConnection()->prepare($sqlrech);
            $stmt->bindValue(':r1',$id1,PDO::PARAM_INT);
            $stmt->bindValue(':r2',$id2,PDO::PARAM_INT);
            $stmt->bindValue(':sens',$sens,PDO::PARAM_STR);
            $stmt->execute();
        } catch (\Symfony\Component\Form\Exception\Exception $e) {
            $stmt = null;
            $res = null;
            var_dump($e->getMessage());
        }
        return $stmt->fetchAll() ;
    }





    public function findDistinctAll( $em){

      
        try {
            $sqlrech = " 
       

            SELECT DISTINCT p1.id as id1, p2.id as id2 ,p1.nom as nom1, p1.contact as contact1, p2.nom as nom2, p2.contact as contact2
   
      from appel a inner join  personne p1 on p1.id = a.peronne_one_id inner join personne p2 on p2.id = a.personne_two_id
      
            
            
            ";
           
                      
            $stmt = $em->getConnection()->prepare($sqlrech);
          
            $stmt->execute();
        } catch (\Symfony\Component\Form\Exception\Exception $e) {
            $stmt = null;
            $res = null;
            var_dump($e->getMessage());
        }
        return $stmt->fetchAll() ;



        
     }
 




}
