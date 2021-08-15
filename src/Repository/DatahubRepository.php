<?php

namespace App\Repository;

use App\Entity\Datahub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use \Symfony\Component\Form\Exception\Exception;
use PDO;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @method Datahub|null find($id, $lockMode = null, $lockVersion = null)
 * @method Datahub|null findOneBy(array $criteria, array $orderBy = null)
 * @method Datahub[]    findAll()
 * @method Datahub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @throws \Exception
 */
class DatahubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Datahub::class);
    }

    // /**
    //  * @return Datahub[] Returns an array of Datahub objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Datahub
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function insertCsvData($em, $fichier) {

       
        
      

        try {
        
        
        
            $sqlrech = " 
            LOAD DATA INFILE '".$fichier."' INTO TABLE datahub
            FIELDS TERMINATED BY ';' 
            OPTIONAlLY ENCLOSED BY '\"' 
            ESCAPED BY '\\\\'
            LINES TERMINATED BY '\\r\\n'
            IGNORE 1 LINES
            (abonne,appele,identite_appele,date,heure,
            duree,type_appel, sens_appel,imsi, imei, localisation); ";           
            $stmt = $em->getConnection()->prepare($sqlrech);
        
            $stmt->execute();
    

            //exit;

        } catch (Exception $e) {
            $stmt = null;
            $res = null;
            var_dump($e->getMessage());
        }
        return 1;
    }

public function datahubUpdateAb($em){

    try {
        $sqlrech = " 
        UPDATE datahub 
        SET abonne = TRIM(abonne)
            
            
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;
}

public function datahubUpdateAp($em){
    
    try {
        $sqlrech = " 
        UPDATE datahub 
        SET appele = TRIM(appele)
            
            
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;
}

public function datahubUpdateIdentiteAppele($em){
    
    try {
        $sqlrech = " 
        UPDATE datahub 
        SET identite_appele = TRIM(identite_appele)
            
            
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;
}

public function datahubUpdateDate($em){
    
    try {
        $sqlrech = " 
        UPDATE datahub 
        SET date = TRIM(date)
            
            
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;
}

public function datahubUpdateHeure($em){
    
    try {
        $sqlrech = " 
        UPDATE datahub 
        SET heure = TRIM(heure)
            
            
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;
}

public function datahubUpdateDuree($em){
    
    try {
        $sqlrech = " 
        UPDATE datahub 
        SET duree = TRIM(duree)
            
            
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;
}

public function datahubUpdateTypeAppel($em){
    
    try {
        $sqlrech = " 
        UPDATE datahub 
        SET type_appel = TRIM(type_appel)
            
            
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;
}

public function datahubUpdateSensAppel($em){
    
    try {
        $sqlrech = " 
        UPDATE datahub 
        SET sens_appel = TRIM(sens_appel)
            
            
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;
}

public function datahubUpdateIMEI($em){
    
    try {
        $sqlrech = " 
        UPDATE datahub 
        SET imei = TRIM(imei)
            
            
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;
}

public function datahubUpdateIMSI($em){
    
    try {
        $sqlrech = " 
        UPDATE datahub 
        SET imsi = TRIM(imsi)
            
            
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;
}

public function datahubUpdateLocalisation($em){
    
    try {
        $sqlrech = " 
        UPDATE datahub 
        SET localisation = TRIM(localisation)
            
            
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;
}





    public function insertNumeroApp($em) {

        try {
            $sqlrech = " 
            INSERT INTO numero (descriptif)

                SELECT DISTINCT appele

                FROM datahub d
                WHERE  d.appele not in(
                    SELECT n.descriptif from numero n
                );  
                
                
                
                ";
               
                          
            $stmt = $em->getConnection()->prepare($sqlrech);
            $stmt->execute();
        } catch (\Symfony\Component\Form\Exception\Exception $e) {
            $stmt = null;
            $res = null;
            var_dump($e->getMessage());
        }

        return 1;
    
    }




    public function insertNumeroAb($em) {


        try {
            $sqlrech = "         
                INSERT INTO numero (descriptif)
                SELECT DISTINCT d.abonne
                FROM datahub d
                WHERE  d.abonne not in(
                    SELECT n.descriptif from numero n
                ) ;
                    
                
                
                ";
               
                          
            $stmt = $em->getConnection()->prepare($sqlrech);
            $stmt->execute();
        } catch (\Symfony\Component\Form\Exception\Exception $e) {
            $stmt = null;
            $res = null;
            var_dump($e->getMessage());
        }
        return 1;


    }







    public function insertNumOp($em) {


        try {
            $sqlrech = "         
               update  numero  set  operateur_id  =
               case 
               when INSTR(SUBSTR(descriptif,1,3),'90') then
                 1
               
              when INSTR(SUBSTR(descriptif,1,3), '91') then
              1
             
             when INSTR(SUBSTR(descriptif,1,3), '92') then
               1
              
             when INSTR(SUBSTR(descriptif,1,3), '70') then
                1

                when INSTR(SUBSTR(descriptif,1,3), '93') then
                1
   

                                     
                 Else
                   2

                 END
                
                ";
               
                          
            $stmt = $em->getConnection()->prepare($sqlrech);
            $stmt->execute();
        } catch (\Symfony\Component\Form\Exception\Exception $e) {
            $stmt = null;
            $res = null;
            var_dump($e->getMessage());
        }
        return 1;


    }


    public function insertIdNumToPerson($em){

        try {
            $sqlrech = "
            UPDATE personne p SET p.numero_id =
             (SELECT n.id from numero n where p.contact = n.descriptif)
                ";
               
                          
            $stmt = $em->getConnection()->prepare($sqlrech);
            $stmt->execute();
        } catch (\Symfony\Component\Form\Exception\Exception $e) {
            $stmt = null;
            $res = null;
            var_dump($e->getMessage());
        }
        return 1;
    
    
    
    }





    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    



    




public function insertPersonneAb($em){

    try {
        $sqlrech = "         
            INSERT IGNORE INTO personne (contact)
            SELECT DISTINCT d.abonne
            FROM  datahub d     
            WHERE d.abonne not in (select contact from personne)
        
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;



}







public function insertPersonneAp($em){

    try {
        $sqlrech = "         
            INSERT IGNORE INTO personne (contact,nom)
            SELECT DISTINCT d.appele,d.identite_appele from datahub d
WHERE d.appele not in  (select contact from personne)
             
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e ){
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;



}






public function insertAppel($em){

    try {
        $sqlrech = "
        INSERT into appel(peronne_one_id,personne_two_id,date,duree,type_appel,sens_appel)
        SELECT a1.id, a2.id,STR_TO_DATE(CONCAT(d.date,d.heure),'%d/%m/%Y %h:%i:%s') ,d.duree,d.type_appel,d.sens_appel from datahub d INNER JOIN personne a1 on a1.contact = d.abonne INNER JOIN personne a2 ON a2.contact = d.appele WHERE
 CONCAT(a1.id,a2.id,STR_TO_DATE(CONCAT(d.date,d.heure),'%d/%m/%Y %h:%i:%s')) not in (SELECT concat(peronne_one_id,personne_two_id,date) as temps from appel) ;

  
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e ){
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;



}


public function insertAntenne($em){
    try {
        $sqlrech = "         
            INSERT IGNORE INTO antenne (nom)
            SELECT DISTINCT localisation 
            FROM  datahub  d
            WHERE  d.localisation not in(
                SELECT a.nom from antenne a
            ) ;   
           
           
           
           
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;



}






public function insertPortable($em){
    try {
        $sqlrech = "         
            INSERT IGNORE INTO portable (personne_id,antenne_id,imei,imsi)
            SELECT  a1.id ,a.id,d.imei,d.imsi
            FROM antenne a,datahub d INNER JOIN personne a1 on a1.contact = d.abonne INNER JOIN personne a2 ON a2.contact = d.appele   
            WHERE CONCAT(a1.id,a2.id,STR_TO_DATE(CONCAT(d.date,d.heure),'%d/%m/%Y %h:%i:%s')) not in (SELECT concat(peronne_one_id,personne_two_id,date) as temps from appel) 
            ";
           
                      
        $stmt = $em->getConnection()->prepare($sqlrech);
        $stmt->execute();
    } catch (\Symfony\Component\Form\Exception\Exception $e) {
        $stmt = null;
        $res = null;
        var_dump($e->getMessage());
    }
    return 1;



}

























































   







    
    }








