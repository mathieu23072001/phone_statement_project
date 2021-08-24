<?php

namespace App\Controller\Ads;

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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\ORM\Query\ResultSetMapping;


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
     * @Route("/import",name="ads_import")
     * @param Request $request
     * @throws \Exception
     */

    public function Import(Request $request,  EntityManagerInterface $entityManager,DatahubRepository $hubdata):Response
    {
       


$user = $this->getUser();

         
        $upload = new Upload();
        

        $form = $this->createForm(UploadType::class, $upload);

        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            //$path= 'C:\xampp\htdocs\exporTest\src\Controller/../../public/uploads/c3900ad16dba7bc3f827f364561dce25releve.csv';
            $entityManager = $this->getDoctrine()->getManager();
            $file = $upload->getName();
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





            //$hubdata->insertCsvData($entityManager,$fileFolder."".$filePathName);
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
             
            
            
          
            
              return $this->redirectToRoute("ads_register_cas");
               
        }
      

        return $this->render('ads/import.html.twig', ['form' => $form->createView(),'user'=>$user]);
            
    }



     /**
     * @Route("/registerCas",name="ads_register_cas")
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

            $this->addFlash('success', 'enregistrement réussie');

            return $this->redirectToRoute("ads_accueil");

        }

        return $this->render('ads/registerCas.html.twig',[
            'user'=>$user,
            'form' => $form->createView()
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
        $query1 = $em->createQuery('SELECT c.nom as nom, c.numero as contact from App:Cas c inner join c.personne p where p.id= :id' );
        $query1->setParameter('id', $id);
        $cas = $query1->getResult();
        
        $query2 = $em->createQuery('SELECT  p.nom as nom, p.contact as numero from App:Personne p where p.id= :id' );
        $query2->setParameter('id', $id);
        $hum = $query2->getSingleResult();
        //$valider = $_POST['valider'];
        
        
       
   
        //dd(json_encode($hum));
        if($chs == null) {
            $n= "koffi";
            return $this->render('ads/treant.html.twig',[
                'hum2'=> json_encode($hum),
                'cas2'=>json_encode($cas),
                'hum'=> $hum,
                'n'=> json_encode($n),
                'cas'=>$cas    
            ]);
           
         }

    $table= [];
    $i = 0;
     foreach ($chs as $ch) {
         $table[$i] = new Cas();
         $per= $em->getRepository(Personne::class)->find($ch);
         $table[$i]->setNom($per->getNom());
         $table[$i]->setNumero($per->getContact());
         $table[$i]->setPersonne( $em->getRepository(Personne::class)->find($id));
         $em->persist($table[$i]);
         $i++;
        
     }
     $em->flush();
    
     

        $n= "koffi";
         dd(json_encode($cas));
        return $this->render('ads/treant.html.twig',[
            'hum'=> json_encode($hum),
            'cas'=>json_encode($cas),
            'hum2'=> $hum,
            'n'=> json_encode($n),
            'cas2'=>$cas    
        ]);
       
    }




     /**
     * @Route("/CasGraphe",name="ads_cas_graphe")
     */

    public function CasGraphe(Request $request):Response
    {
        $user = $this->getUser();
        $nom = "koffi";
        
        return $this->render('sms/treant.html.twig', [
            'n'=> json_encode($nom),
            'user'=>$user
            
        ]);
         
       
       
    }

     
     
    
}
