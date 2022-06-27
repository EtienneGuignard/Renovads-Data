<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateDbConttrollerController extends AbstractController
{
    #[Route('/create/db/conttroller', name: 'app_create_db_conttroller')]
    public function index( EntityManagerInterface $entityManagerInterface): Response
    {
        $name=$_POST['name'];
        test($entityManagerInterface, $name);
        return $this->render('create_db_conttroller/index.html.twig', [
            'controller_name' => 'CreateDbConttrollerController',
        ]);
    }
    
}
function test( $entityManagerInterface, $name){

    $conn=$entityManagerInterface->getConnection();
    $rawSql="CREATE TABLE campaign2 (id INT AUTO_INCREMENT NOT NULL, $name VARCHAR(255) NOT NULL) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB";
    $query=$conn->prepare($rawSql);
    $query->executeQuery();
}