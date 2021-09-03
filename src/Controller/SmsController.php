<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use telesign\sdk\messaging\MessagingClient;

class SmsController extends AbstractController
{
    /**
     * @Route("/sms", name="sms")
     */
    public function index(Request $request): Response
    {
        $mobile = $request->get('mobile');
        $message = $request->get('message');

        $customer_id = "EBC52519-57DD-49EB-A636-FB47C7DBC02F";
  $api_key = "7lQlJGp6XJlxA5UFHMisnrb3zUBFigtS/t1jCF+G8DWKcGX0hcRxMqljWDfhtoigyFq9x8SMxpauTmhYYXJ/Aw==";
  $phone_number =$mobile;
  $message = $message;
  $message_type = "ARN";
  $messaging = new MessagingClient($customer_id, $api_key);
  $response = $messaging->message($phone_number, $message, $message_type);
        return $this->render('sms/index.html.twig', [
            'controller_name' => 'SmsController',
            'response'=>$response,
        ]);
    }

    /**
         * @Route("/treant", name="treantGraph")
         */
    public function treant(Request $request)
    {
        $nom = "koffi";
        
        return $this->render('sms/treant.html.twig', [
            'controller_name' => 'SmsController',
            'n'=> json_encode($nom)
            
        ]);
    }




     /**
         * @Route("/vis", name="visGraph")
         */
        public function vis(Request $request)
        {
            $em = $this->getDoctrine()->getManager();
      
            $query1 = $em->createQuery('SELECT DISTINCT p from App:Personne p inner join p.appelsOne a'  );

            $query2 = $em->createQuery('SELECT DISTINCT p from App:Personne p inner join p.appelsTwo a'  );

           $query3 = $em->createQuery('SELECT DISTINCT p.id as id, p.contact as contact, p.nom as nom from App:Personne p');
           $query4 = $em->createQuery('SELECT DISTINCT a from App:Appel a');

            $per1 = $query1->getResult();
            $per2 = $query2->getResult();
            $per3 = $query3->getResult();
            $per4 = $query4->getResult();

            //dd($per4);
            
            
            return $this->render('sms/vis.html.twig', [
                'per3'=> $per3,
                'per4'=> $per4,
                'controller_name' => 'SmsController'
                
                
            ]);
        }
    
    

}