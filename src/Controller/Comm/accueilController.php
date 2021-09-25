<?php

namespace App\Controller\Comm;

use PDO;
use connect;
use PDOException;
use App\Entity\Appel;
use App\Entity\Personne;
use App\Entity\Commissaire;
use App\Form\CommissaireType;
use App\Form\registerNomType;
use App\Repository\AppelRepository;
use App\Repository\DatahubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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

    public function CommAppel(Request $request,AppelRepository $appDetails,AppelRepository $distinct){ 

      $entityManager = $this->getDoctrine()->getManager();

      try{
        // Connexion à la bdd
        $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
        $db->exec('SET NAMES "UTF8"');
    } catch (PDOException $e){
        echo 'Erreur : '. $e->getMessage();
        die();
    }


   
   



      
     // $appels= $this->getDoctrine()->getRepository(Appel::class)->findAll();
      $appels = $distinct->findDistinctAll($entityManager);

     
     // dd($appels);
    $tab1= [];
    $tab2= [];
    
    $data = [];
  
    $i = 0;
    
  
    foreach($appels as $appel ){
     
    
    
     
    
     // $data[$i]['personne1'] =  $appel->getPeronneOne()->getId();
       $data[$i]['personne1'] = $appel['id1'];
  
       $data[$i]['nom1'] = $appel['nom1'];
       $data[$i]['contact1'] = $appel['contact1'];
     // $data[$i]['personne2'] =   $appel->getPersonneTwo()->getId();
      $data[$i]['personne2'] = $appel['id2'];
       $data[$i]['nom2'] = $appel['nom2'];
       $data[$i]['contact2']= $appel['contact2'];
     
      
          $data[$i]['sortie'] = $appDetails->detailsAppel($entityManager, $data[$i]['personne1'], $data[$i]['personne2'], "S");
          $data[$i]['entree'] = $appDetails->detailsAppel($entityManager, $data[$i]['personne1'], $data[$i]['personne2'], "E");
      

    // $var1 = $data[$i]['personne1'];
    // $var2 = $data[$i]['personne2'];

      //$appDetails->detailsAppel($entityManager,$data[$i]['personne1'],$data[$i]['personne2'],$data[$i]['sens']);

     

     $i++;
    
     
     
    
    }
  
    //dd($data);
    
        return $this->render('comm/appel.html.twig',[
         'data'=> $data
        
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
    
    


        /**
         * @Route("/itineraire/{id}", name="comm_itineraire")
         */
        public function itineraire(Request $request,$id){
           
          try{
            // Connexion à la bdd
            $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
            $db->exec('SET NAMES "UTF8"');
        } catch (PDOException $e){
            echo 'Erreur : '. $e->getMessage();
            die();
        }
        $sql = 'SELECT a.nom as nomA,p.nom as nom,p.contact as contact,ap.date as dte, ap.duree as duree,po.imei as imei,po.imsi as imsi, a.longitude as longitude, a.latitude as latitude from antenne a inner join appel ap on a.id = ap.antenne_id inner join portable po on po.id = ap.portable_id inner join personne p on p.id = ap.personne_two_id  where ap.peronne_one_id = :id';
        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetchAll();
       // dd($result);
        





          return $this->render('comm/itineraire.html.twig', [
           
            'result'=> $result
            
        ]);

        }





          /**
         * @Route("/personneCible", name="comm_personne_cible")
         */
        public function Cible(){

          try{
            // Connexion à la bdd
            $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
            $db->exec('SET NAMES "UTF8"');
        } catch (PDOException $e){
            echo 'Erreur : '. $e->getMessage();
            die();
        }
        $sql = 'SELECT DISTINCT p.id as id, p.nom as nom, p.contact as contact, po.imei as imei,po.imsi as imsi from personne p inner join appel a on p.id = a.peronne_one_id inner join portable po on po.id= a.portable_id';
        $query = $db->prepare($sql);

         
        $query->execute();

        $result = $query->fetchAll();
        




          return $this->render('comm/cible.html.twig', [
           'result'=> $result
            
            
        ]);

        }


     
          /**
         * @Route("/detailsAppel/{id1}/{id2}", name="comm_details_appel")
         */

      public function detailsAppel($id1, $id2){

       

       $appels= $this->getDoctrine()->getRepository(Appel::class)->findby(['peronneOne'=>$id1,'personneTwo'=>$id2]);
       // dd($appels);
       foreach($appels as $appel){
           $one = $appel->getPeronneOne()->getNom();
           $two = $appel->getPersonneTwo()->getNom();

       }


       return $this->render('comm/details.html.twig',[
         'appels'=> $appels,
         'one'=>$one,
         'two'=>$two
       ]);

      }
      
      



       /**
         * @Route("/searchDays/", name="comm_search_days")
         */

public function SearchDays(Request $request,AppelRepository $appeldata): Response{

 
    $date = $request->get('date');
    $debut = $request->get('debut');
    $fin = $request->get('fin');

   $dateD = $date." ".$debut.':00';
 
   $dateF =  $date." ".$fin.':00';
  
   $call = $appeldata->AppelByDate2($dateD,$dateF);

  // dd($call);


  


  return $this->render('comm/searchDays.html.twig',[
    'call'=> $call
  ]);


  

}




 /**
         * @Route("/searchOneCible/", name="comm_search_oneCible")
         */

        public function SearchOnecible(Request $request,AppelRepository $appeldata): Response{

          
              $cible = $request->get('cible');
              $debut = $request->get('debut');
              $fin = $request->get('fin');
              $fin= $fin." ".'23:59:59';
            
          
          
              $personne= $this->getDoctrine()->getRepository(Personne::class)->findOneby(['contact'=>$cible]);
          
            //  $id = $personne->getId();
            // $nom = $personne->getNom();
            //  $num = $personne->getContact();
           
              

              $call = $appeldata->AppelByDate3($personne, $debut, $fin);
          
             

                    


              return $this->render('comm/searchOneCible.html.twig',[
                'call'=> $call,
                
               
              ]);
          

            

             

          }
      
      
      
        
      
      
      
      
        
      
    
        



         /**
         * @Route("/importCible/", name="comm_import_cible")
         * @param Request $request
         * @throws \Exception
         */

       
        public function ImportCible(Request $request,  EntityManagerInterface $entityManager,DatahubRepository $hubdata):Response
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
        
        
        
        
        
              // $hubdata->insertCsvData($entityManager,$fileFolder."".$filePathName);
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
                 
                
                
              
                
                  return $this->redirectToRoute("comm_import_success");
                   
            }
          
        
            return $this->render('comm/import.html.twig', ['user'=>$user]);
                
        }
        
  
      



        /**
     * @Route("/import_succes",name="comm_import_success")
     */

    public function importSuccess(Request $request)
    {
     

        
        

        
        return $this->render('comm/traitementOK1.html.twig',[
            
        ] );
    }









    /**
     * @Route("/addName",name="comm_add_name")
     */

    public function addName(Request $request):Response
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

            

            return $this->redirectToRoute("comm_add_success");

        }

        return $this->render('comm/addName.html.twig',[
            'user'=>$user,
            'form' => $form->createView()
        ]);
            
    }


    


     /**
     * @Route("/add_succes",name="comm_add_success")
     */

    public function AddSuccess(Request $request)
    {
     

        
        

        
        return $this->render('comm/traitementOK2.html.twig',[
            
        ] );
    }

     
     
    
}
