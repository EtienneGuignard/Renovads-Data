<?php

namespace App\Controller;

use App\Entity\BodyForwarder;
use App\Form\BodyForwarderType;
use App\Repository\BodyForwarderRepository;
use App\Repository\ForwarderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
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
    public function testForwarder( BodyForwarderRepository $bodyForwarderRepository, ForwarderRepository $forwarderRepository ): Response
    {
        if (isset($_GET['routeParams'])) {
            $routeParam=$_GET['routeParams'];
            $forwarderId=$routeParam['forwarderId'];
            $referUrl='http://127.0.0.1:8000' . $_GET['referrer'];
            
            $bodies=$bodyForwarderRepository->findByFkforwarder($forwarderId);
            $forwarder=$forwarderRepository->find($forwarderId);
            $fwUrl=$forwarder->getUrl();

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
                 
        $i=0;
        $bodyArr=[];
        if (isset($_POST['submit'] )) {

            $forwarderId=$_POST['forwarderId'];
            // var_dump($forwarderId);
            $bodies=$bodyForwarderRepository->findByFkforwarder($forwarderId);
          
        foreach ($bodies as  $body) {
            $type=$body->getType();
            $output=$body->getOutpout();
            $input=$body->getInput();
            $i= $i + 1;

            if ($type=='field') {
                $bodyArr[$output]=$_POST[$i];
            }
            if ($type=='static') {
                $bodyArr[$input]=$_POST[$i];
            }

        }
;
        $fwUrl=$_POST['fwUrl'];
    
       
        $client= HttpClient::create();
        $response=$client->request('POST', $fwUrl, [
         'body' => $bodyArr,
         
     ]);
     $statusCode = $response->getStatusCode();
     // $statusCode = 200
     $contentType = $response->getHeaders()['content-type'][0];
     var_dump($contentType);
     // $contentType = 'application/json'
     $content = $response->getContent();
     // $content = '{"id":521583, "name":"symfony-docs", ...}'
     $url=$_POST['url'] . '&statusCode=' . $statusCode . '&contentType=' . $contentType  . '&content=' . $content;
     return $this->redirect($url);
       
    }
   
       


        return $this->render('forwarder/test.html.twig', [

            'bodies'=> $bodies,
            'forwarderId'=> $forwarderId,
            'url'=>$url,
            'i'=>$i,
            'fwUrl'=>$fwUrl
        ]);
    }
    
}

function postDataTest($bodyArr, $fwUrl, $url){
  

}
