<?php

namespace App\Controller\Admin;

use PDO;
use connect;
use PDOException;
use App\Entity\User;
use App\Entity\Membre;
use App\Entity\Personne;
use App\Form\registerNomType;
use App\Repository\CDSRepository;
use App\Repository\DatahubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/admin")
     */


class accueilController extends AbstractController
{
    
    /**
     * @Route("/accueil",name="admin_accueil")
     */

public function Admin(Request $request,CDSRepository $cdsRepo){



    try{
        // Connexion à la bdd
        $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
        $db->exec('SET NAMES "UTF8"');
    } catch (PDOException $e){
        echo 'Erreur : '. $e->getMessage();
        die();
    }
    $sql1 = 'SELECT count(*) as total from user u  where u.type = 2 ';
    $query1 = $db->prepare($sql1);

    
    $query1->execute();

    $result1 = $query1->fetchAll();



    $sql2= 'SELECT count(*) as total from user u  where u.active = 1 ';
    $query2 = $db->prepare($sql2);

    
    $query2->execute();

    $result2 = $query2->fetchAll();



    $sql3= 'SELECT count(*) as total from user u  where u.active = 0 ';
    $query3 = $db->prepare($sql3);

    
    $query3->execute();

    $result3 = $query3->fetchAll();
    


    $sql4= 'SELECT count(*) as total from user u  where u.type = 0';
    $query4 = $db->prepare($sql4);

    
    $query4->execute();

    $result4 = $query4->fetchAll();


    $sql5= 'SELECT count(*) as total from user u  where u.type = 1';
    $query5 = $db->prepare($sql5);

    
    $query5->execute();

    $result5 = $query5->fetchAll();


    
    $sql6= 'SELECT count(*) as total from user u  where u.type = 3';
    $query6 = $db->prepare($sql6);

    
    $query6->execute();

    $result6 = $query6->fetchAll();
    


    $sql7= 'SELECT count(*) as total from cds ';
    $query7 = $db->prepare($sql7);

    
    $query7->execute();

    $result7 = $query7->fetchAll();
    


    $sql8= 'SELECT count(*) as total from user u  where u.type = 3 AND u.active = 0';
    $query8 = $db->prepare($sql8);

    
    $query8->execute();

    $result8 = $query8->fetchAll();
    
    


    $sql9= 'SELECT count(*) as total from user u  where u.type = 1 AND u.active = 0 ';
    $query9 = $db->prepare($sql9);

    
    $query9->execute();

    $result9 = $query9->fetchAll();




    $sql10= 'SELECT count(*) as total from user u  where u.type = 0 AND u.active = 0';
    $query10 = $db->prepare($sql10);

    
    $query10->execute();

    $result10 = $query10->fetchAll();





    $cds = $cdsRepo->findAll();

    $cdsNom = [];
    $cdsColor = [];
    $cdsCount = [];

    // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
    foreach($cds as $cds){
        $cdsNom[] = $cds->getNom();
        $cdsColor[] = $cds->getColor();
        $cdsCount[] = count($cds->getMembres());
    }

    

  return $this->render('admin/accueil.html.twig',[
      'result1'=> $result1,
      'result2'=>$result2,
      'result3'=>$result3,
      'result4'=>$result4,
      'result5'=>$result5,
      'result6'=>$result6,
      'result7'=>$result7,
      'result8'=>$result8,
      'result9'=>$result9,
      'result10'=>$result10,
      'cdsNom'=> json_encode($cdsNom),
      'cdsColor'=> json_encode($cdsColor),
       'cdsCount'=> json_encode($cdsCount)
  ]);
    
}




 /**
     * @Route("/import",name="admin_import")
     * @param Request $request
     * @throws \Exception
     */




public function Import(Request $request,  EntityManagerInterface $entityManager,DatahubRepository $hubdata):Response
{
   


$user = $this->getUser();

     
   
   
    if (!empty($_POST)) {

        //$path= 'C:\xampp\htdocs\exporTest\src\Controller/../../public/uploads/c3900ad16dba7bc3f827f364561dce25releve.csv';
        $entityManager = $this->getDoctrine()->getManager();
        $file = $request->files->get('fichier');
        //dd($file);
       // $fileName = md5(uniqid()).'.'.$file->guessExtension();
     //   $fileFolder= $file->move($this->getParameter('upload_directory'),$fileName);
       // $fileFolder = __DIR__ . '/../../public/uploads/';  //choose the folder in which the uploaded file will be stored
        $fileFolder = 'C:/xampp/htdocs/exporTest/public/uploads/';
        $filePathName = md5(uniqid()) . $file->getClientOriginalName();
       
       
      
      

        try {
            $file->move($fileFolder, $filePathName);
        } catch (FileException $e) {
            dd($e);
        }
        
        
       // dd($fileFolder."".$filePathName);





       $hubdata->insertCsvData($entityManager,$fileFolder."".$filePathName);
        $hubdata->datahubAb($entityManager);
          $hubdata->datahubAp($entityManager);
          
         $hubdata->datahubUpdateAb($entityManager);
         $hubdata->datahubUpdateAp($entityManager);
          $hubdata->datahubUpdateIdentiteAppele($entityManager);
        $hubdata->datahubUpdateDate($entityManager);
        $hubdata->datahubUpdateHeure($entityManager);
         $hubdata->datahubUpdateDuree($entityManager);
        $hubdata->datahubUpdateTypeAppel($entityManager);
         $hubdata->datahubUpdateSensAppel($entityManager);
          $hubdata->datahubUpdateIMEI($entityManager);
          $hubdata->datahubUpdateIMSI($entityManager);
         $hubdata->datahubUpdateLocalisation($entityManager);
         $hubdata->insertNumeroAb($entityManager);
          $hubdata->insertNumeroApp($entityManager);    
        $hubdata->insertNumOp($entityManager);
          $hubdata->insertpersonneAb($entityManager);
          $hubdata->insertpersonneAp($entityManager);
            
         $hubdata->insertAntenne($entityManager);
          $hubdata->insertPortable($entityManager);
          $hubdata->insertIdNumToPerson($entityManager); 
          $hubdata->insertAppel($entityManager);
         
        
        
      
        
          return $this->redirectToRoute("admin_register_success");
           
    }
  

    return $this->render('admin/import.html.twig', ['user'=>$user]);
        
}




/**
     * @Route("/register_succes",name="admin_register_success")
     */

    public function registerSuccess(Request $request)
    {
     

        
        

        
        return $this->render('traitementOK1.html.twig',[
            
        ] );
    }







 /**
     * @Route("/registerCas",name="admin_register_cas")
     */

    public function RegisterCas(Request $request):Response
    {

        $personne = new Personne();

        $form = $this->createForm(registerNomType::class, $personne);
        $form->handleRequest($request);
        $user = $this->getUser();
       // $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
         
        if ($form->isSubmitted() && $form->isValid()) {
            $num= $form->get('numero')->getData();
            $nom= $form->get('nom')->getData();
            
            $cas= $this->getDoctrine()->getRepository(Personne::class)->findOneBy(['contact'=> $num]);
            $cas->setNom($nom);
            $em->persist($cas);
            $em->flush();

            

            return $this->redirectToRoute("admin_register_success");

        }

        return $this->render('admin/registerCas.html.twig',[
            'user'=>$user,
            'form' => $form->createView()
        ]);
            
    }



   


/**
     * @Route("/list_ads",name="admin_list_ads")
     */

    public function adsList(Request $request)
    {
     
    
        try{
            // Connexion à la bdd
            $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
            $db->exec('SET NAMES "UTF8"');
        } catch (PDOException $e){
            echo 'Erreur : '. $e->getMessage();
            die();
        }
        $sql = 'SELECT u.id as id,u.active as etat,u.email as email,m.nom as nom,m.prenoms as prenoms,c.nom as cds  from user u inner join membre m on(m.user_id = u.id) inner join cds c on (m.cds_id= c.id ) where u.type = 0 ';
        $query = $db->prepare($sql);
    
        
        $query->execute();
    
        $result = $query->fetchAll();
    
      //  dd($result);
        

        
        return $this->render('admin/listAds.html.twig',[
            'result'=>$result
        ] );
    }





    /**
     * @Route("/list_rdc",name="admin_list_rdc")
     */

    public function rdcList(Request $request)
    {
     
    
        try{
            // Connexion à la bdd
            $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
            $db->exec('SET NAMES "UTF8"');
        } catch (PDOException $e){
            echo 'Erreur : '. $e->getMessage();
            die();
        }
        $sql = 'SELECT u.id as id,u.active as etat,u.email as email,m.nom as nom,m.prenoms as prenoms,c.nom as cds  from user u inner join membre m on(m.user_id = u.id) inner join cds c on (m.cds_id= c.id ) where u.type = 1 ';
        $query = $db->prepare($sql);
    
        
        $query->execute();
    
        $result = $query->fetchAll();
    
      //  dd($result);
        

        
        return $this->render('admin/listRdc.html.twig',[
            'result'=>$result
        ] );
    }






      /**
     * @Route("/list_comm",name="admin_list_comm")
     */

    public function commList(Request $request)
    {
     
    
        try{
            // Connexion à la bdd
            $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
            $db->exec('SET NAMES "UTF8"');
        } catch (PDOException $e){
            echo 'Erreur : '. $e->getMessage();
            die();
        }
        $sql = 'SELECT u.id as id,u.active as etat,u.email as email,c.nom as nom,c.prenoms as prenoms  from user u inner join commissaire c on(c.user_id = u.id)  where u.type = 3';
        $query = $db->prepare($sql);
    
        
        $query->execute();
    
        $result = $query->fetchAll();
    
      //  dd($result);
        

        
        return $this->render('admin/listComm.html.twig',[
            'result'=>$result
        ] );
    }












    /**
     * @Route("/active_userAds/{id}",name="admin_active_userAds")
     */

public function activeUserAds($id){

    $em = $this->getDoctrine()->getManager();
    $user= $this->getDoctrine()->getRepository(User::class)->find($id);

    $user->setActive(1);

    $em->persist($user);
    $em->flush();

    
return $this->redirectToRoute('admin_list_ads');



}







 /**
     * @Route("/active_userRdc/{id}",name="admin_active_userRdc")
     */

    public function activeUserRdc($id){

        $em = $this->getDoctrine()->getManager();
        $user= $this->getDoctrine()->getRepository(User::class)->find($id);
    
        $user->setActive(1);
    
        $em->persist($user);
        $em->flush();
    
        
    return $this->redirectToRoute('admin_list_rdc');
    
    
    
    }
    
    
    

    /**
     * @Route("/active_userComm/{id}",name="admin_active_userComm")
     */

    public function activeUserComm($id){

        $em = $this->getDoctrine()->getManager();
        $user= $this->getDoctrine()->getRepository(User::class)->find($id);
    
        $user->setActive(1);
    
        $em->persist($user);
        $em->flush();
    
        
    return $this->redirectToRoute('admin_list_comm');
    
    
    
    }
    
    






/**
     * @Route("/desactive_userAds/{id}",name="admin_desactive_userAds")
     */

    public function desactiveUserAds($id){
    
        $em = $this->getDoctrine()->getManager();
     
        $user= $this->getDoctrine()->getRepository(User::class)->find($id);
    
        $user->setActive(0);
    
        $em->persist($user);
        $em->flush();
    return $this->redirectToRoute('admin_list_ads');
    
    
    
    }
     
     


    /**
     * @Route("/desactive_userRdc/{id}",name="admin_desactive_userRdc")
     */

    public function desactiveUserRdc($id){
    
        $em = $this->getDoctrine()->getManager();
     
        $user= $this->getDoctrine()->getRepository(User::class)->find($id);
    
        $user->setActive(0);
    
        $em->persist($user);
        $em->flush();
    return $this->redirectToRoute('admin_list_rdc');
    
    
    
    }






    /**
     * @Route("/desactive_userComm/{id}",name="admin_desactive_userComm")
     */

    public function desactiveUserComm($id){
    
        $em = $this->getDoctrine()->getManager();
     
        $user= $this->getDoctrine()->getRepository(User::class)->find($id);
    
        $user->setActive(0);
    
        $em->persist($user);
        $em->flush();
    return $this->redirectToRoute('admin_list_comm');
    
    
    
    }







    

    
}
