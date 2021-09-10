<?php

namespace App\Controller\Comm;

use PDO;
use connect;
use PDOException;
use App\Entity\Commissaire;
use App\Form\CommissaireType;
use Doctrine\ORM\EntityManagerInterface;
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

        $sql = 'select distinct peronne_one_id, personne_two_id , count(sens_appel) as E, count(sens_appel) as S from appel a1 INNER JOIN personne p1 ON a1.peronne_one_id = p1.id inner join personne p2 ON p2.id= a1.personne_two_id
        
        group by peronne_one_id, personne_two_id
        ';

    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll();
  dd($result);


        return $this->render('comm/appel.html.twig');
          
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
