<?php

namespace App\Controller;

use App\Entity\ApiToken;
use App\Entity\BodyForwarder;
use App\Entity\Campaign;
use App\Entity\Forwarder;
use App\Entity\Leads;
use App\Entity\RuleGroup;
use App\Entity\Supplier;
use App\Entity\User;
use App\Form\BodyForwarderType;
use App\Repository\BodyForwarderRepository;
use App\Repository\ForwarderRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForwarderController extends AbstractDashboardController
{
    #[Route('/forwarder/{forwarderId}', name: 'app_forwarder')]
    public function indexForwarder(EntityManagerInterface $entityManagerInterface, 
    Request $request, BodyForwarderRepository $bodyForwarderRepository, int $forwarderId,
     ForwarderRepository $forwarderRepository): Response
    {

        if (isset($_GET['routeParams'])) {
            $routeParam=$_GET['routeParams'];
            $forwarderId=$routeParam['forwarderId'];
        
        }
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {  
            $url = "https://";   
            }else{  
                $url = "http://";   
                // Append the host(domain name, ip) to the URL.   
                $url.= $_SERVER['HTTP_HOST'];   
                // Append the requested resource location to the URL   
                $url.= $_SERVER['REQUEST_URI'];  
            }  
        $forwarderList = $bodyForwarderRepository->findByFkforwarder($forwarderId);
        $bodyForwarder= new BodyForwarder;
        $form= $this->createForm(BodyForwarderType::class, $bodyForwarder);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            $forwarder=$forwarderRepository->find($forwarderId);
            $bodyForwarder->setFkForwarder($forwarder);
            $entityManagerInterface->persist($bodyForwarder);
            $entityManagerInterface->flush();
            return $this->redirect($url);
        }

        return $this->render('forwarder/index.html.twig', [
            'controller_name' => 'ForwarderController',
            'form'=> $form->createView(),
            'forwarderId'=> $forwarderId,
            'url'=>$url,
            'forwarderList'=>$forwarderList
        ]);
    }

    #[Route('/forwarder/body/delete/{id}/{bodyForwarderId}', name: 'delete_body_forwarder')]
    public function deleteUser(
    EntityManagerInterface $entityManagerInterface,
    ForwarderRepository $forwarderRepository,
    BodyForwarderRepository $bodyForwarderRepository ,
    Forwarder $forwarder,
    int $id,
    int $bodyForwarderId,
    ): Response 
{  
            $forwarder=$forwarderRepository->find($id);
            $bodyForwarderField=$bodyForwarderRepository->find($bodyForwarderId);
            $forwarder->removeBodyForwarder($bodyForwarderField);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_forwarder',['forwarderId'=>$id]);
        
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

        };
        $fwUrl=$_POST['fwUrl'];
        $client= HttpClient::create();
        $response=$client->request('POST', $fwUrl, [
        'body' => $bodyArr,
        
    ]);
    $statusCode = $response->getStatusCode();
     // $statusCode = 200
    $contentType = $response->getHeaders()['content-type'][0];
     // $contentType = 'application/json'
    $content = $response->getContent();
     // $content = '{"id":521583, "name":"symfony-docs", ...}'
    $url=$_POST['url'] . '&statusCode=' . $statusCode . '&contentType=' . $contentType  . '&content=' . $content;
    return $this->redirect($url);
    }



        return $this->render('forwarder/test.html.twig', [

            'bodies'=> $bodies,
            'i'=>$i,
            'fwUrl'=>$fwUrl
        ]);
    }

    public function configureDashboard(): Dashboard
{
    return Dashboard::new()
        ->setTitle('Select');
}

public function configureMenuItems(): iterable
{
    yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    // necessary to implement easyadmin in app_select_rule_group
    yield MenuItem::linkToRoute('select', 'fa fa-home', 'app_select_rule_group')
    ->setCssClass("d-none");
    
    yield MenuItem::linkToRoute('select', 'fa fa-home', 'app_report_results')
    ->setCssClass("d-none");
    yield MenuItem::linkToCrud('Rule group', 'fas fa-list', RuleGroup::class);
    yield MenuItem::linkToCrud('Campaign', 'fas fa-bullhorn', Campaign::class);
    yield MenuItem::linkToCrud('Leads', 'fas fa-user', Leads::class);
    yield MenuItem::linkToCrud('Supplier', 'fas fa-building', Supplier::class);
    yield MenuItem::linkToCrud('Forwader', 'fas fa-exchange', Forwarder::class);
    yield MenuItem::linkToRoute('Report', 'fa fa-bar-chart', 'app_report');
    yield MenuItem::linkToCrud('Users', 'fas fa-address-book', User::class);
    yield MenuItem::linkToCrud('Token', 'fas fa-certificate', ApiToken::class);
}
    
}

function postDataTest($bodyArr, $fwUrl, $url){
  

}
