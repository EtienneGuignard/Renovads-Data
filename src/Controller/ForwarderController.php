<?php

namespace App\Controller;

use App\Entity\BodyForwarder;
use App\Entity\Forwarder;
use App\Form\BodyForwarderType;
use App\Form\ForwarderType;
use App\Repository\BodyForwarderRepository;
use App\Repository\ForwarderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForwarderController extends AbstractController
{
    #[Route('/forwarder', name: 'app_forwarder')]
    public function index(EntityManagerInterface $entityManagerInterface, Request $request, BodyForwarderRepository $bodyForwarderRepository, ForwarderRepository $forwarderRepository): Response
    {

        if (isset($_GET['routeParams'])) {
            $routeParam=$_GET['routeParams'];
            $forwarderId=$routeParam['forwarderId'];
            $referUrl='http://127.0.0.1:8000' . $_GET['referrer'];
        echo $referUrl;
        $forwarderList = $bodyForwarderRepository->findByFkforwarder($forwarderId);
        }
                        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {  
                        $url = "https://";   
                        }
                else{  
                        $url = "http://";   
                // Append the host(domain name, ip) to the URL.   
                $url.= $_SERVER['HTTP_HOST'];   
                
                // Append the requested resource location to the URL   
                $url.= $_SERVER['REQUEST_URI'];  
            }  
                    

        $bodyForwarder= new BodyForwarder;
        $form= $this->createForm(BodyForwarderType::class, $bodyForwarder);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            $forwarder=$forwarderRepository->find($forwarderId);
            // var_dump($forwarder);
            $bodyForwarder->setFkForwarder($forwarder);
            $entityManagerInterface->persist($bodyForwarder);
            $entityManagerInterface->flush();
            return $this->redirect($url);
        }

        $array1=['test', 'test1'];
        $array2= ['jean', 'frank'];
        $array= array_combine($array1, $array2);
        var_dump($array);

        return $this->render('forwarder/index.html.twig', [
            'controller_name' => 'ForwarderController',
            'form'=> $form->createView(),
            'forwarderId'=> $forwarderId,
            'refer'=>$referUrl,
            'forwarderList'=>$forwarderList
        ]);
    }
}
