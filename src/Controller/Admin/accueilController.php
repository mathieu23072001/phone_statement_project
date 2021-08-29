<?php

namespace App\Controller\Admin;

use PDO;
use connect;
use PDOException;
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


class accueilController extends AbstractController
{
    
  
    /**
     * @Route("/accueil",name="admin_accueil")
     */

    public function Admin()
    {
       
     header('Access-Control-Allow-Origin: *');

// On vérifie qu'on utilise la méthode GET
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // On se connecte à la BDD
    

    try{
        // Connexion à la bdd
        $db = new PDO('mysql:host=localhost;dbname=bdtest', 'root','');
        $db->exec('SET NAMES "UTF8"');
    } catch (PDOException $e){
        echo 'Erreur : '. $e->getMessage();
        die();
    }

    

    $sql = 'SELECT id, nom, latitude, longitude, ( 6371 * acos( cos( radians(:latitude) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(:longitude) ) + sin( radians(:latitude) ) * sin( radians( latitude ) ) ) ) AS distance FROM `cds` HAVING distance < :distance ORDER BY distance';

    $query = $db->prepare($sql);

    $query->bindValue(':latitude', $_GET['lat'], PDO::PARAM_STR);    
    $query->bindValue(':longitude', $_GET['lon'], PDO::PARAM_STR);
    $query->bindValue(':distance', $_GET['distance'], PDO::PARAM_INT);    
    $query->execute();

    $result = $query->fetchAll();

    http_response_code(200);

  //  echo json_encode($result);

    $db = null;
    return $this->render('admin/accueil1.html.twig',[
        'result'=>$result
    ]);
    

}else{
    http_response_code(405);
    echo 'Méthode non autorisée';
}

        return $this->render('admin/accueil1.html.twig');
    }



     
     
    
}
