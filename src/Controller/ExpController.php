<?php

namespace App\Controller;

use PDO;

use App\Entity\Upload;

use App\Form\UploadType;
use App\Repository\DatahubRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;




class ExpController extends AbstractController
{
    /**
     * @Route("/exp", name="exp",methods={"GET","POST"})
     * @param Request $request
     * @throws \Exception
     */
    public function index(Request $request,  EntityManagerInterface $entityManager,DatahubRepository $hubdata):Response
    {

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





           // $hubdata->insertCsvData($entityManager,$fileFolder."".$filePathName);
             // $hubdata->datahubUpdateAb($entityManager);
             // $hubdata->datahubUpdateAp($entityManager);
            //  $hubdata->datahubUpdateIdentiteAppele($entityManager);
            //  $hubdata->datahubUpdateDate($entityManager);
            //  $hubdata->datahubUpdateHeure($entityManager);
           //  $hubdata->datahubUpdateDuree($entityManager);
           //  $hubdata->datahubUpdateTypeAppel($entityManager);
           //   $hubdata->datahubUpdateSensAppel($entityManager);
           //   $hubdata->datahubUpdateIMEI($entityManager);
           //   $hubdata->datahubUpdateIMSI($entityManager);
           //   $hubdata->datahubUpdateLocalisation($entityManager);
            //  $hubdata->insertNumeroAb($entityManager);
            //  $hubdata->insertNumeroApp($entityManager);    
            //  $hubdata->insertNumOp($entityManager);
             // $hubdata->insertpersonneAb($entityManager);
             // $hubdata->insertpersonneAp($entityManager);
              // $hubdata->insertIdNumToPerson($entityManager);    
           //  $hubdata->insertAppel($entityManager);
            //  $hubdata->insertAntenne($entityManager);
            //  $hubdata->insertPortable($entityManager);
              
            
            
          
            
           return $this->json('success', 200);
               
        }
      
            
           
        
 return $this->render('exp/index.html.twig', ['form' => $form->createView()]);
 
    }

   
}
