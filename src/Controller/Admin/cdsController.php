<?php

namespace App\Controller\Admin;
use PDO;
use PDOException;
use App\Entity\CDS;
use App\Form\CdsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/admin")
     */


class cdsController extends AbstractController
{
    
  
    /**
     * @Route("/add/cds",name="admin_add_cds")
     */

    public function add_cds(Request $request):Response
    {
        $cds = new CDS();

        $form = $this->createForm(cdsType::class, $cds);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

    
        if ($form->isSubmitted() && $form->isValid()){
            
            $em->persist($cds);
            $em->flush();
            $this->addFlash('success', 'enregistrement réussie');
            return $this->redirectToRoute("admin_list_cds");

        }
    



        
        return $this->render('admin/addCds.html.twig',['form' => $form->createView()] );
    }








     /**
     * @Route("/list/cds",name="admin_list_cds")
     */

    public function list_cds()
    {
       
    
        $result= $this->getDoctrine()->getRepository(CDS::class)->findAll();


        
        return $this->render('admin/listCds.html.twig',['result'=> $result ] );
    }





     /**
     * @Route("/position/cds/{id}",name="admin_position_cds")
     */

    public function position_cds($id)
    {
       
    
        try{
            // Connexion à la bdd
            $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
            $db->exec('SET NAMES "UTF8"');
        } catch (PDOException $e){
            echo 'Erreur : '. $e->getMessage();
            die();
        }
        $sql = 'SELECT c.latitude as latitude,c.longitude as longitude, c.nom as nom,c.quartier as quartier from cds c where c.id= :id ';
        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetchAll();
       // dd($result);
        



        
        return $this->render('admin/positionCds.html.twig',['result'=> $result ] );
    }



     
     
    
}
