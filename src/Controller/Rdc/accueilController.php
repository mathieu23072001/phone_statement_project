<?php

namespace App\Controller\Rdc;

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
use telesign\sdk\messaging\MessagingClient;



/**
 * Controller used to manage blog contents in the backend.
 *
 * 
 * 
 */

  /**
     * @Route("/rdc")
     */


class accueilController extends AbstractController
{
    
  
    /**
     * @Route("/accueil",name="rdc_accueil")
     */

    public function Rdc()
    {
        $user = $this->getUser();

        return $this->render('rdc/accueil.html.twig',[
            'user'=>$user
        ]);
            
    }




   
     
     
    
}
