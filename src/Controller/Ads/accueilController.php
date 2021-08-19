<?php

namespace App\Controller\Ads;

use APP\Entity\User;
use App\Entity\Upload;
use App\Entity\Personne;
use App\Form\UploadType;
use App\Form\registerNomType;
use App\Repository\DatahubRepository;
use Doctrine\ORM\EntityManagerInterface;
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
                 $hubdata->insertAppel($entityManager);
             $hubdata->insertAntenne($entityManager);
              $hubdata->insertPortable($entityManager);
              $hubdata->insertIdNumToPerson($entityManager); 
              
            
            
          
            
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
        $form->handleRequest($request);
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

     
     
    
}
