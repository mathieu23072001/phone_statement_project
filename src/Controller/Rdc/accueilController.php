<?php

namespace App\Controller\Rdc;

use PDO;
use PDOException;
use App\Entity\Cas;
use APP\Entity\User;
use App\Entity\Appel;
use App\Form\CasType;
use App\Entity\Upload;
use App\Entity\Personne;
use App\Form\NumeroType;
use App\Form\UploadType;
use App\Form\PersonneType;
use App\Form\registerNomType;
use App\Form\RechercheCasType;
use App\Repository\AppelRepository;
use App\Repository\DatahubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use telesign\sdk\messaging\MessagingClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;



/**
 * Controller used to manage blog contents in the backend.
 *
 * 
 * 
 */

  /**
     * @Route("/rdc")
     */


class accueilController extends AbstractController
{
    
  
    /**
     * @Route("/accueil",name="rdc_accueil")
     */

    public function Rdc()
    {
        $user = $this->getUser();

        return $this->render('rdc/accueil.html.twig',[
            'user'=>$user
        ]);
            
    }






    /**
     * @Route("/centreInfos",name="rdc_centre_infos")
     */

    public function centreInfos(Request $request)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

            $membre = $user->getMembres();
            foreach($membre as $membre){
                $cds = $membre->getCds();
            }
            
        if (!empty($_POST)) {

              if(!empty($request->get('nom'))){

                $nom = $request->get('nom');
                $cds->setNom($nom);
                
              }

              if(!empty($request->get('email'))){

                $email = $request->get('email');
                $cds->setEmail($email);
                
            }

            if(!empty($request->get('site'))){

                $site = $request->get('site');
                $cds->setSite($site);
                
            }

            if(!empty($request->get('quartier'))){

                $quartier = $request->get('quartier'); 
                $cds->setQuartier($quartier);
                
            }

            if(!empty($request->get('horaire'))){

                $horaire = $request->get('horaire'); 
                $cds->setHoraire($horaire);
                
            }



            if(!empty($request->get('contact'))){

                $contact = $request->get('contact'); 
                $cds->setContact($contact);
                
            }
           
            $em->persist($cds);
            
            $em->flush();

            return $this->redirectToRoute('rdc_centre_infos');
            
            
        
        }





        return $this->render('rdc/infoCentre.html.twig',[
            'user'=>$user
        ]);
            
    }
   


     
    
    /**
     * @Route("/agentSante",name="rdc_agent_sante")
     */

 public function agentSante(){

    $user = $this->getUser();

    $membre = $user->getMembres();
    foreach($membre as $membre){
        $id = $membre->getCds()->getId();
    }
    

    try{
        // Connexion à la bdd
        $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
        $db->exec('SET NAMES "UTF8"');
    } catch (PDOException $e){
        echo 'Erreur : '. $e->getMessage();
        die();
    }
    $sql = 'SELECT u.id as id,u.active as etat,u.email as email,m.nom as nom,m.prenoms as prenoms,c.nom as cds  from user u inner join membre m on(m.user_id = u.id) inner join cds c on (m.cds_id= c.id ) where u.type = 0 AND c.id = :id ';
    $query = $db->prepare($sql);

    $query->bindValue(':id', $id, PDO::PARAM_STR); 
    $query->execute();

    $result = $query->fetchAll();

     
    return $this->render('rdc/agentSante.html.twig',[
        'result'=>$result
    ] );

 }
 
 




 
    /**
     * @Route("/active_userAds/{id}",name="rdc_active_userAds")
     */

public function activeUserAds($id){

    $em = $this->getDoctrine()->getManager();
    $user= $this->getDoctrine()->getRepository(User::class)->find($id);

    $user->setActive(1);

    $em->persist($user);
    $em->flush();

    
return $this->redirectToRoute('rdc_agent_sante');



}







/**
     * @Route("/desactive_userAds/{id}",name="rdc_desactive_userAds")
     */

    public function desactiveUserAds($id){
    
        $em = $this->getDoctrine()->getManager();
     
        $user= $this->getDoctrine()->getRepository(User::class)->find($id);
    
        $user->setActive(0);
    
        $em->persist($user);
        $em->flush();
    return $this->redirectToRoute('rdc_agent_sante');
    
    
    
    }
    
     
     
    
}
