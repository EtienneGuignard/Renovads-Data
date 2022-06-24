<?php

namespace App\Controller;

use App\Entity\Leads;
use App\Form\LeadsType;
use App\Repository\LeadsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\FrameworkConfig;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManagerInterface, LeadsRepository $leadsRepository, Request $request, ): Response
    {
        $lead= new Leads;
        $form= $this->createForm(LeadsType::class, $lead);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            // $task = $form->getData();
            // print_r($task);
            $email= $lead->getEmail();
            $fisrtname= $lead->getFirstname();
            echo $fisrtname;
            
            // $fisrtname=$_POST['leads[firstname]'];
            // $dob=$_POST['leads[dob][day]'] . '-' . $_POST['leads[dob][month]'] . '-' .$_POST['leads[dob][year]'] ;
            postData($email, $fisrtname);

            $entityManagerInterface->persist($lead);
            $entityManagerInterface->flush();
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form'=> $form->createView(),
            'email'=> $email
        ]);
    }
}


function postData($email, $fisrtname){
    $client= HttpClient::create();
        $client->request('POST', 'https://incallsrl.databowl.com/api/v1/lead', [
        // defining data using a regular string
        'body' => [
            'cid' => '331',
            'sid' => '34',
            'f_1_email' => $email, 
            'f_3_firstname' => $fisrtname,
        ],
    ]);
}