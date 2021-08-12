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
         * @Route("/sendSms", name="sendsms")
         */
    public function sendMessage(Request $request)
    {
        $mobile = $request->get('mobile');
        $message = $request->get('message');
        $encodeMessage = urldecode($message);
        $authKey = '7lQlJGp6XJlxA5UFHMisnrb3zUBFigtS/t1jCF+G8DWKcGX0hcRxMqljWDfhtoigyFq9x8SMxpauTmhYYXJ/Aw==';
        $senderId = 'EBC52519-57DD-49EB-A636-FB47C7DBC02F';
        $route = 4;
        $url ='';
        $postData = array(
        'mobile' => $mobile,
        'encodeMessage' => $encodeMessage,
        'authKey' => $authKey,
        'sendId'=>$senderId,
        'route' => $route,

       );

        $url ='';
        $ch = curl_init();
        curl_setopt_array($ch, array(

        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => True,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,

        ));

        Curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        Curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);

        if(Curl_error($ch)){
            echo '' . curl_error($ch);


        }

        curl_close($ch);
        
        return $this->render('sms/success.html.twig', [
            'controller_name' => 'SmsController',
            
        ]);
    }
}