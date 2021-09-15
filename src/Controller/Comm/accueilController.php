<?php

namespace App\Controller\Comm;

use PDO;
use connect;
use PDOException;
use App\Entity\Appel;
use App\Entity\Commissaire;
use App\Form\CommissaireType;
use Doctrine\ORM\EntityManagerInterface;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Controller used to manage blog contents in the backend.
 *
 * 
 * 
 */

  /**
     * @Route("/comm")
     */


class accueilController extends AbstractController
{
    
    /**
     * @Route("/accueil",name="comm_accueil")
     */

public function Comm(Request $request){

  


  return $this->render('comm/accueil.html.twig');
    
}



 /**
     * @Route("/appel",name="comm_appel")
     */

    public function CommAppel(Request $request){ 
      
      try{
      // Connexion à la bdd
      $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
      $db->exec('SET NAMES "UTF8"');
  } catch (PDOException $e){
      echo 'Erreur : '. $e->getMessage();
      die();
  }


      $appels= $this->getDoctrine()->getRepository(Appel::class)->findAll();
    $tab1= [];
    $tab2= [];
    $tab3= array();
    $i = 0;
    $j = 0;
    foreach($appels as $appel ){
    // $id1= $appel->getPeronneOne()->getId();
    //  $id2= $appel->getPersonneTwo()->getId();
     $tab1[$i] = $appel->getPeronneOne()->getId();
     $tab2[$j] = $appel->getPersonneTwo()->getId();
     $tab3[0]= array($appel->getPeronneOne()->getId(),$appel->getPersonneTwo()->getId());
     

     $sql = 'SELECT count(a.sens_appel) as sortie, a.peronne_one_id,a.personne_two_id from appel a, personne p1, personne p2 where  p1.id = :r1  AND p2.id = :r2 AND sens_appel = "S" ';
     $query = $db->prepare($sql);
     $query->bindValue(':r1', $tab1[$i], PDO::PARAM_STR);    
     $query->bindValue(':r2', $tab2[$j], PDO::PARAM_STR); 
     $query->execute();
     $result = $query->fetchAll(); 


   //   $em = $this->getDoctrine()->getManager();
    //  $query1 = $em->createQuery('SELECT DISTINCT p.nom as nom, p.contact as contact from App:Personne p  where p.id= :id' );
    //  $query1->setParameter('id', $tab[$i]);
    //  $pers1 = $query1->getResult();


     // $query2 = $em->createQuery('SELECT DISTINCT p.nom as nom, p.contact as contact from App:Personne p  where p.id= :id' );
     // $query2->setParameter('id', $tab[$j]);
     // $pers2 = $query2->getResult();

      //$query3 = $em->createQuery('SELECT count(*) as entree from App:Appel a inner join a.peronneOne p1 inner join a.personneTwo p2 where p1.id= :id1 AND p2.id= :id2');
      //$query3->setParameter('id1',$tab[$i]);
      //$query3->setParameter('id2',$tab[$j]);
      //$result = $query3->getResult();
     $i++;
     $j++;
    // dd($result);
    
    }
   // $i++;
   // $j++;
   dd($result);






    
        return $this->render('comm/appel.html.twig',[
          
          
        ]);
          
      }

 







 /**
         * @Route("/vis", name="comm_vis")
         */
        public function vis(Request $request)
        {
            $em = $this->getDoctrine()->getManager();
      
            $query1 = $em->createQuery('SELECT DISTINCT p from App:Personne p inner join p.appelsOne a'  );

            $query2 = $em->createQuery('SELECT DISTINCT p from App:Personne p inner join p.appelsTwo a'  );

           $query3 = $em->createQuery('SELECT DISTINCT p.id as id, p.contact as contact, p.nom as nom from App:Personne p');
           $query4 = $em->createQuery('SELECT DISTINCT a from App:Appel a');

            $per1 = $query1->getResult();
            $per2 = $query2->getResult();
            $per3 = $query3->getResult();
            $per4 = $query4->getResult();

            //dd($per4);
            
            
            return $this->render('comm/vis.html.twig', [
                'per3'=> $per3,
                'per4'=> $per4
                
                
                
            ]);
        }
    
    

     
     
    
}
