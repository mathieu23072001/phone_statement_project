<?php

namespace App\Controller\Comm;

use PDO;
use connect;
use PDOException;
use App\Entity\Appel;
use App\Entity\Personne;
use App\Entity\Commissaire;
use App\Form\CommissaireType;
use App\Repository\AppelRepository;
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
          
             foreach($call as $call1){

                     $nom= $call1->getPeronneOne()->getNom();
                     $num = $call1->getPeronneOne()->getContact();
             }


              return $this->render('comm/searchOneCible.html.twig',[
                'call'=> $call,
                'nom'=>$nom,
                'num'=>$num
               
              ]);
          

            

             

          }
        // dd($call);
      
      
        
      
      
      
      
        
      
      
      





     
     
    
}
