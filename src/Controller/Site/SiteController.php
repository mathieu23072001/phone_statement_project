<?php

namespace App\Controller\Site;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use telesign\sdk\messaging\MessagingClient;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="site")
     */
    public function index()
    {
      
        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
            
        ]);
    }





     
    
    

}