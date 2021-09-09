<?php

namespace App\Controller\Membre;

use App\Entity\CDS;
use APP\Entity\User;
use App\Entity\Membre;
use App\Form\MembreType;
use App\Entity\Commissaire;
use App\Form\CommissaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/membre")
     */


class registerController extends AbstractController
{
    
  
    /**
     * @Route("/register/{id}",name="membre_register")
     */

    public function register(Request $request, $id, UserPasswordEncoderInterface $encoder):Response
    {
        $users = new User();
        $cds = $this->getDoctrine()->getRepository(CDS::class)->find($id);
        
        
    // var_dump($fonction);
       $user= $this->getDoctrine()->getRepository(User::class)->findBy(['type'=>1 ]);
        $r= $this->getDoctrine()->getRepository(Membre::class)->findOneBy(['cds'=> $cds,'user'=>$user]);
       //$r = $cdsMembre->getUser()->getRoles();
       
        
        
        $membre = new Membre();
        $form = $this->createForm(MembreType::class, $membre);
        
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
      


        if ($form->isSubmitted() && $form->isValid()) {
           
            $role= $form->get('role')->getData();
            if($r == null && $role =="agent de sante"){
                return $this->json('Aucun chef affecte a ce centre. Patientez !!!', 200);
            }

            if($r == null && $role =="responsable de centre"){
                $hash= $encoder->encodePassword($membre->getUser(), $membre->getUser()->getPassword());
                $membre->getUser()->setPassword($hash);
                $membre->getUser()->setRoles(["ROLE_RDC"]);
                $membre->setCds($cds);
                $membre->getUser()->setType(1);
           

                $em->persist($membre);
                $em->flush();

                $this->addFlash('success', 'enregistrement réussie');
                return $this->redirectToRoute("membre_register_success");
            }
           
            if( $r!=null && $role == "responsable de centre"){
                return $this->json('Ce centre possede deja un responsable !!!', 200);
            }
           
            if ($r != null && $role =="agent de sante") {
                $hash= $encoder->encodePassword($membre->getUser(), $membre->getUser()->getPassword());
                $membre->getUser()->setPassword($hash);
                $membre->getUser()->setRoles(["ROLE_ADS"]);
                $membre->setCds($cds);
                $membre->getUser()->setType(0);
           

                $em->persist($membre);
                $em->flush();

                $this->addFlash('success', 'enregistrement réussie');
                return $this->redirectToRoute("membre_register_success");
            }
           
        

           
        }
    

        
        return $this->render('membre/register.html.twig',['form' => $form->createView()] );
    }











    /**
     * @Route("/register_start",name="membre_register_start")
     */

    public function registerStart(Request $request)
    {
        $cds= $this->getDoctrine()->getRepository(CDS::class)->findAll();

        
        

        
        return $this->render('membre/registerStart.html.twig',[
            'cds'=> $cds
        ] );
    }






    /**
     * @Route("/register_succes",name="membre_register_success")
     */

    public function registerSuccess(Request $request)
    {
     

        
        

        
        return $this->render('traitementOK.html.twig',[
            
        ] );
    }










     /**
     * @Route("/registerComm",name="membre_comm_register")
     */

public function RegisterComm(Request $request,UserPasswordEncoderInterface $encoder):Response{

    $comm = new Commissaire();
    $form = $this->createForm(CommissaireType::class, $comm);
    
    $form->handleRequest($request);
    $em = $this->getDoctrine()->getManager();
  
    if ($form->isSubmitted() && $form->isValid()) {
      $hash= $encoder->encodePassword($comm->getUser(), $comm->getUser()->getPassword());
  
      $comm->getUser()->setPassword($hash);
      $comm->getUser()->setRoles(["ROLE_COMM"]);
      $comm->getUser()->setType(3);
  
      $em->persist($comm);
      $em->flush();
  
      return $this->redirectToRoute("membre_register_success");
  
  
  
  
  
  
    }
  
  
    return $this->render('comm/register.html.twig',['form' => $form->createView()]);
      
  }
  






     
     
    
}
