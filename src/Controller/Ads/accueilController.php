<?php

namespace App\Controller\Ads;

use file;
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
use Dompdf\Dompdf;
use Dompdf\Options;


/**
 * Controller used to manage blog contents in the backend.
 *
 * 
 * 
 */

  /**
     * @Route("/ads")
     */


class accueilController extends AbstractController
{
    
  
    /**
     * @Route("/accueil",name="ads_accueil")
     */

    public function Ads()
    {
        $user = $this->getUser();

        return $this->render('ads/accueil.html.twig',[
            'user'=>$user
        ]);
            
    }




   


      /**
     * @Route("/registerCasContact",name="ads_register_cas_contact")
     */

    public function RegisterCasContact(Request $request)
    {
        $user = $this->getUser();
        $personne = new Personne();
       // $cas = new Cas();
        

        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);
        
       // $form->handleRequest($request);
      

        if($form->isSubmitted() && $form->isValid()){
            $num= $form->get('contact')->getData();
            $cas = $form->get('cas')->getData();
            $per= $this->getDoctrine()->getRepository(Personne::class)->findOneBy(['contact'=> $num]);
            $ident = $per->getId();
           // $cas->setPersonne($per);
           foreach($cas as $c){
               $per->addCa($c);

            $em = $this->getDoctrine()->getManager();
            // $em->persist($cas);
             $em->persist($per);
              
              $em->flush();
        
               
           }
          
           
            $this->addFlash('success', 'enregistrement réussie');
           return $this->redirectToRoute("ads_search_releve",['id'=>$ident]);
        }
         
       
        return $this->render('ads/registerCasInfo.html.twig',[
            'user'=>$user,
            'form' => $form->createView()
        ]);
            
    }



     /**
     * @Route("/searchReleve/{id}",name="ads_search_releve",defaults={ "id" = 1})
     */

    public function searchReleve(Request $request,$id, AppelRepository $appeldata,EntityManagerInterface $entityManager):Response
    {
        $appel = new Appel();

        $form = $this->createForm(RechercheCasType::class);
        $form->handleRequest($request);

        $user = $this->getUser();
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
           $dateD= $form->get('dateI')->getData();
           $stringDate = $dateD->format('Y-m-d ');

           // $dateD = "2020-01-15";
            $dateF = date('Y-m-d', strtotime( $stringDate . ' + 14 days'));

          // $call= $this->getDoctrine()->getRepository(Appel::class)->findby(['peronneOne'=>$id]);
        $call= $appeldata->AppelByDate($id,$stringDate,$dateF);
           $nom = "koffi";
            

           return $this->render('ads/listCasReleve.html.twig', [
            'user'=>$user,
            'nom'=>$nom,
            'call'=>$call
            
        ]);     
           
        }
 
        return $this->render('ads/cas.html.twig', [
            'user'=>$user,
            'form' => $form->createView()
            
        ]);
         
       
       
    }



    
     /**
     * @Route("/Ajoutcas",name="ads_cas_Ajout")
     */

    public function AjoutCas(Request $request)
    {
        $cas = new Cas();
        $personne = new Personne();
        
        $chs = $request->request->get('call');
        $id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
      //  $query1 = $em->createQuery('SELECT c.nom as nom, c.numero as contact from App:Cas c inner join c.personne p where p.id= :id' );
       // $query1->setParameter('id', $id);
       // $cas = $query1->getResult();
        
     //   $query2 = $em->createQuery('SELECT  p.nom as nom, p.contact as numero from App:Personne p where p.id= :id' );
      //  $query2->setParameter('id', $id);
      //  $hum = $query2->getSingleResult();
        //$valider = $_POST['valider'];
        
        //dd(json_encode($hum));
        if($chs == null) {

            $query1 = $em->createQuery('SELECT DISTINCT c.nom as nom, c.numero as contact from App:Cas c inner join c.personne p where p.id= :id' );
            $query1->setParameter('id', $id);
            $cas = $query1->getResult();
            
            $query2 = $em->createQuery('SELECT  p.nom as nom, p.contact as numero from App:Personne p where p.id= :id' );
            $query2->setParameter('id', $id);
            $hum = $query2->getSingleResult();
    
            return $this->render('ads/treant.html.twig',[
                'hum2'=> json_encode($hum),
                'cas2'=>json_encode($cas),
                'hum'=> $hum,      
                'cas'=>$cas    
            ]);
           
         }

    $table= [];
    $i = 0;
     foreach ($chs as $ch) {
         $table[$i] = new Cas();
         $per= $em->getRepository(Personne::class)->find($ch);
         $cont1 = $per->getContact();
         $idd = $em->getRepository(Personne::class)->find($id);
        
         $cont2 = $em->getRepository(Cas::class)->findOneby(['numero'=>$cont1,'personne'=>$idd]);
         if (!$cont2) {
             $table[$i]->setNom($per->getNom());
             $table[$i]->setNumero($per->getContact());
             $table[$i]->setPersonne($em->getRepository(Personne::class)->find($id));
             $em->persist($table[$i]);
             $i++;
         }
     }
     $em->flush();
    
     $em = $this->getDoctrine()->getManager();
     $query1 = $em->createQuery('SELECT DISTINCT c.nom as nom, c.numero as contact from App:Cas c inner join c.personne p where p.id= :id' );
     $query1->setParameter('id', $id);
     $cas = $query1->getResult();
     
     $query2 = $em->createQuery('SELECT  p.nom as nom, p.contact as numero from App:Personne p where p.id= :id' );
     $query2->setParameter('id', $id);
     $hum = $query2->getSingleResult();

        
        // dd(json_encode($cas));
        return $this->render('ads/treant.html.twig',[
            'hum'=> $hum,
            'cas'=>$cas,  
        ]);
       
    }




     /**
     * @Route("/ListPatient",name="ads_patient_list")
     */

    public function PatientList(Request $request)
    {
        $user = $this->getUser();
        $cas = new Cas();
        $em = $this->getDoctrine()->getManager();
      
            //  $cas = $em->getRepository(Cas::class)->findAll();

           // $query1 = $em->createQuery('SELECT DISTINCT p.id as id ,p.nom as nom, p.contact as contact  from App:Personne p where p.id = (select DISTINCT IDENTITY(c.personne) from App:Cas c )');

           // $query1 = $em->createQuery('SELECT DISTINCT c.personne as personne   from App:Cas c where personne = (select DISTINCT p.id from App:Personne p )');
            $query1 = $em->createQuery('SELECT DISTINCT p from App:Personne p inner join p.cas c');
        
            $cas = $query1->getResult();
        
        
   
        
        return $this->render('ads/patientList.html.twig', [
            'cas'=> $cas,
            'user'=>$user
            
        ]);
         
       
       
    }



     /**
     * @Route("/ListCas",name="ads_cas_list")
     */

    public function CasList(Request $request)
    {
        $user = $this->getUser();
        $cas = new Cas();
        $em = $this->getDoctrine()->getManager();

        $cas = $em->getRepository(Cas::class)->findAll();
     
        
   
        
        return $this->render('ads/casList.html.twig', [
            'cas'=> $cas,
            'user'=>$user
            
        ]);
         
       
       
    }





    
     /**
     * @Route("/CasGraphe/{id}",name="ads_cas_graphe")
     */

    public function CasGraphe(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $query1 = $em->createQuery('SELECT DISTINCT c.nom as nom, c.numero as contact from App:Cas c inner join c.personne p where p.id= :id' );
        $query1->setParameter('id', $id);
        $cas = $query1->getResult();
        
        $query2 = $em->createQuery('SELECT  p.nom as nom, p.contact as numero from App:Personne p where p.id= :id' );
        $query2->setParameter('id', $id);
        $hum = $query2->getSingleResult();
       

        return $this->render('ads/treant.html.twig',[
            'hum'=> $hum,      
            'cas'=>$cas    
        ]);
        
   
         
       
       
    }


/**
     * @Route("/sms", name="ads_sms")
     */
    public function adsSms(Request $request): Response
    {
        //$mobile = $request->get('mobile');
       // $message = $request->get('message');

        $customer_id = "EBC52519-57DD-49EB-A636-FB47C7DBC02F";
  $api_key = "7lQlJGp6XJlxA5UFHMisnrb3zUBFigtS/t1jCF+G8DWKcGX0hcRxMqljWDfhtoigyFq9x8SMxpauTmhYYXJ/Aw==";
  $phone_number = "22892855872";
  $message = "Il est très probable que vous aillez été en contact avec une personne infectée. Rendez-vous sur ce lien pour prendre un rendez-vous de dépistage";
  $message_type = "ARN";
  $messaging = new MessagingClient($customer_id, $api_key);
  $response = $messaging->message($phone_number, $message, $message_type);

        return $this->render('ads/accueil.html.twig');
           
    }

    


    /**
     * @Route("/printCas", name="ads_print_cas")
     */
    
     public function PrintCas(){


        $user = $this->getUser();
        $cas = new Cas();
        $em = $this->getDoctrine()->getManager();

        $cas = $em->getRepository(Cas::class)->findAll();
       





 
 // Configure Dompdf according to your needs
 $pdfOptions = new Options();
 $pdfOptions->set('defaultFont', 'Arial');
 
 // Instantiate Dompdf with our options
 $dompdf = new Dompdf($pdfOptions);
 
 // Retrieve the HTML generated in our twig file
 $html = $this->renderView('ads/casList.html.twig', [
     'title' => "Liste des cas contacts",
     'cas'=> $cas,
     'user'=>$user
 ]);
 
 // Load HTML to Dompdf
 $dompdf->loadHtml($html);
 
 // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
 $dompdf->setPaper('A4', 'portrait');

 // Render the HTML as PDF
 $dompdf->render();

 // Output the generated PDF to Browser (inline view)
 $dompdf->stream("mypdf.pdf", [
     "Attachment" => false
 ]);










     }
     
    
}
