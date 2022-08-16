<?php

namespace App\Controller;

use App\Controller\Admin\DashboardController;
use App\Entity\BodyForwarder;
use App\Entity\Forwarder;
use App\Form\BodyForwarderType;
use App\Form\ForwarderType;
use App\Repository\BodyForwarderRepository;
use App\Repository\ForwarderRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
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

        return $this->render('forwarder/index.html.twig', [
            'controller_name' => 'ForwarderController',
            'form'=> $form->createView(),
            'forwarderId'=> $forwarderId,
            'refer'=>$referUrl,
            'forwarderList'=>$forwarderList
        ]);
    }

    #[Route('/forwarder/test/', name: 'app_forwarder_test')]
    public function testForwarder(EntityManagerInterface $entityManagerInterface, Request $request, BodyForwarderRepository $bodyForwarderRepository, ForwarderRepository $forwarderRepository, AdminUrlGenerator $adminUrlGenerator, ): Response
    {
        if (isset($_GET['routeParams'])) {
            $routeParam=$_GET['routeParams'];
            $forwarderId=$routeParam['forwarderId'];
            $referUrl='http://127.0.0.1:8000' . $_GET['referrer'];
            
           
        }
        $bodies=$bodyForwarderRepository->findByFkforwarder($forwarderId);
                 
        $i=0;
        $bodyArr=[];
        if (isset($_POST[1])) {
            $bodies=$bodyForwarderRepository->findByFkforwarder($forwarderId);
        foreach ($bodies as $key => $body) {
            $i=$i++;
            $bodyOuput=$body['output'];
            var_dump($bodyOuput);
            $bodyArr[]=$_POST[$i];

        
        }
        var_dump($bodyArr);
        return $this->redirect($url);
    }
            
       


        return $this->render('forwarder/test.html.twig', [
            'controller_name' => 'ForwarderController',
            'bodies'=> $bodies,
            'forwarderId'=> $forwarderId,
            'url'=>$url,
            'i'=>$i
        ]);
    }
    
}
