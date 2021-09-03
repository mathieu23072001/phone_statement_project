<?php

namespace App\Controller\Admin;

use PDO;
use connect;
use PDOException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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


class accueilController extends AbstractController
{
    
    /**
     * @Route("/accueil",name="admin_accueil")
     */

public function Admin(Request $request){

  $ip = $request->request->server->get('REMOTE_ADDR');


  return $this->render('admin/accueil.html.twig',[
    'ip'=>$ip
  ]);
    
}





    

     
     
    
}
