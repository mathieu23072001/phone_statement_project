<?php

namespace App\Controller\Membre;

use App\Entity\CDS;
use App\Entity\Membre;
use App\Form\MembreType;
use APP\Entity\User;
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
       $user= $this->getDoctrine()->getRepository(User::class)->findOneBy(['roles'=>["ROLE_RDC"] ]);
        $r= $this->getDoctrine()->getRepository(Membre::class)->findBy(['cds'=> $cds,'user'=>$users]);
       //$r = $cdsMembre->getUser()->getRoles();
       
        var_dump($user);
        
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
           

                $em->persist($membre);
                $em->flush();

                $this->addFlash('success', 'enregistrement réussie');
                return $this->redirectToRoute("app_login");
            }
           
            if( $r!=null && $role == "responsable de centre"){
                return $this->json('Ce centre possede deja un responsable !!!', 200);
            }
           
            if ($r != null && $role =="agent de sante") {
                $hash= $encoder->encodePassword($membre->getUser(), $membre->getUser()->getPassword());
                $membre->getUser()->setPassword($hash);
                $membre->getUser()->setRoles(["ROLE_ADS"]);
                $membre->setCds($cds);
           

                $em->persist($membre);
                $em->flush();

                $this->addFlash('success', 'enregistrement réussie');
                return $this->redirectToRoute("app_login");
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















     
     
    
}
