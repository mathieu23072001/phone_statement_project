<?php

namespace App\Controller\CasContact;

use PDO;
use connect;
use PDOException;
use App\Entity\CDS;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * Controller used to manage blog contents in the backend.
 *
 * 
 * 
 */

  /**
     * @Route("/casContact")
     */


class casController extends AbstractController
{
    
  
    /**
     * @Route("/accueil1",name="casContact_accueil1")
     */

    public function casContact1(Request $request)
    {
        if ($request->query->get('lat')) {  
            // Ajax request  
            //$data = $request->request->get('ville');
            $lat = $request->query->get('lat');
            $lon = $request->query->get('lon');
            $distance = $request->query->get('distance');
        
            //  dd($distance);
            if($lat != null && $lon != null && $distance != null){
                try{
                    // Connexion à la bdd
                    $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
                    $db->exec('SET NAMES "UTF8"');
                } catch (PDOException $e){
                    echo 'Erreur : '. $e->getMessage();
                    die();
                }
                $sql = 'SELECT id, nom, latitude, longitude, quartier,email,contact,site_w,( 6371 * acos( cos( radians(:latitude) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(:longitude) ) + sin( radians(:latitude) ) * sin( radians( latitude ) ) ) ) AS distance FROM `cds` HAVING distance < :distance ORDER BY distance';
                $query = $db->prepare($sql);
      
                $query->bindValue(':latitude', $lat, PDO::PARAM_STR);    
                $query->bindValue(':longitude', $lon, PDO::PARAM_STR);
                $query->bindValue(':distance', $distance, PDO::PARAM_INT);    
                $query->execute();

                $result = $query->fetchAll();
                http_response_code(200);
                $resultat = json_encode($result);
            //    echo json_encode($result);
               return new JsonResponse($result);
                // return $this->render('admin/accueil1.html.twig',[
                //     "agence"=>$resultat
                // ]);

                // return new ;


            } else {  
                // Normal request  
         } 

        
    /*return $this->render('admin/accueil1.html.twig',[
        'resultat'=>$resultat
    ]);*/
    

        }else{

           
          // return $this->redirectToRoute("admin_add_cds");
        }
        return $this->render('CasContact/casContact1.html.twig');
    }



    
    /**
     * @Route("/accueil2",name="casContact_accueil2")
     */

public function casContact2(Request $request){


 if ($request->query->get('lat')) {  
            // Ajax request  
            //$data = $request->request->get('ville');
            $lat = $request->query->get('lat');
            $lon = $request->query->get('lon');
            $distance = $request->query->get('distance');
        
            //  dd($distance);
            if($lat != null && $lon != null && $distance != null){
                try{
                    // Connexion à la bdd
                    $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
                    $db->exec('SET NAMES "UTF8"');
                } catch (PDOException $e){
                    echo 'Erreur : '. $e->getMessage();
                    die();
                }
                $sql = 'SELECT id, nom, latitude, longitude, quartier, email,contact,site_w,( 6371 * acos( cos( radians(:latitude) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(:longitude) ) + sin( radians(:latitude) ) * sin( radians( latitude ) ) ) ) AS distance FROM `cds` HAVING distance < :distance ORDER BY distance';
                $query = $db->prepare($sql);
      
                $query->bindValue(':latitude', $lat, PDO::PARAM_STR);    
                $query->bindValue(':longitude', $lon, PDO::PARAM_STR);
                $query->bindValue(':distance', $distance, PDO::PARAM_INT);    
                $query->execute();

                $result = $query->fetchAll();
                http_response_code(200);
                $resultat = json_encode($result);
            //    echo json_encode($result);
               return new JsonResponse($result);
                // return $this->render('admin/accueil1.html.twig',[
                //     "agence"=>$resultat
                // ]);

                // return new ;


            } else {  
                // Normal request  
         } 

        
    /*return $this->render('admin/accueil1.html.twig',[
        'resultat'=>$resultat
    ]);*/
    

        }else{

           
          // return $this->redirectToRoute("admin_add_cds");
        }
        return $this->render('casContact/casContact2.html.twig');
    }






/**
     * @Route("/Test",name="casContact_Test")
     */

    public function Test(){


        $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
        $db->exec('SET NAMES "UTF8"');
        $em = $this->getDoctrine()->getManager();
       
        $query = $em->createQuery('SELECT c.nom as nom, c.latitude as latitude, c.longitude as longitude from App:CDS c' );
        
        $result = $query->getResult();
        
       $resultat =   $result;
            
//
// On encode en json et on envoie
    

        


        return $this->render('casContact/test.html.twig',[
            'resultat'=> $resultat
            
        ]);
    

    }

     
     
    
}
