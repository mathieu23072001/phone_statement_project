<?php

namespace App\Controller\Admin;
use App\Entity\CDS;
use App\Form\CdsType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;


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
            return $this->redirectToRoute("admin_add_cds");

        }
    



        
        return $this->render('admin/addCds.html.twig',['form' => $form->createView()] );
    }



     
     
    
}
