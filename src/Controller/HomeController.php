<?php

namespace App\Controller;

use App\Entity\BodyForwarder;
use App\Entity\CampaignLeads;
use App\Entity\Leads;
use App\Entity\RuleGroup;
use App\Form\LeadsType;
use App\Repository\BodyForwarderRepository;
use App\Repository\CampaignRepository;
use App\Repository\ForwarderRepository;
use App\Repository\LeadsRepository;
use App\Repository\RuleGroupRepository;
use DateTime;
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
    public function index(EntityManagerInterface $entityManagerInterface, LeadsRepository $leadsRepository, Request $request, CampaignRepository $campaignRepository,
    RuleGroupRepository $ruleGroupRepository,
    ForwarderRepository $forwarderRepository,
    BodyForwarderRepository $bodyForwarderRepository,
    ): Response
    {
    
        $lead= new Leads;
        $form= $this->createForm(LeadsType::class, $lead);
        $form->handleRequest($request);
        $campaigns= $campaignRepository->findAll();
        bodyForwarder($forwarderRepository, $lead, $bodyForwarderRepository);
        foreach ($campaigns as $campaign){
            $campaignId=$campaign->getId();
            echo $campaignId;
        };

        if ($form->isSubmitted() && $form->isValid()) { 

            $email= $lead->getEmail();
            $fisrtname= $lead->getFirstname();
            echo $fisrtname;
            
            postData($email, $fisrtname);
            return $this->redirectToRoute('app_api');
            $entityManagerInterface->persist($lead);
            $entityManagerInterface->flush();
            // rulesFunction($ruleGroupRepository, $lead, $entityManagerInterface, $campaignRepository);
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form'=> $form->createView(),
            
            
        ]);
    }
}


// function postData($email, $fisrtname){
//     $client= HttpClient::create();
//         $client->request('POST', 'http://127.0.0.1:8000/api/lead/v2', [
//         // defining data using a regular string
//         'body' => [
//             'cid' => '331',
//             'sid' => '34',
//             'f_1_email' => $email, 
//             'f_3_firstname' => $fisrtname,
//         ],
//     ]);
// }

// function rulesFunction(RuleGroupRepository $ruleGroupRepository, $data, $entityManagerInterface, $campaignRepository)
//     {
//         $rules=$ruleGroupRepository->findAll();
//         foreach($rules as $rule){
//             $ruleName=$rule->getName();
//             $ruleFieldEntry=$rule->getField();
//             $ruleValue=$rule->getValue();
//             $ruleValueDate=$rule->getValueDate();
//             $ruleFkCampaign=$rule->getFkCampaign();
//             $ruleOperator=$rule->getOperator();
//             $ruleFieldDeter=deterRuleField($ruleFieldEntry, $data);
//             foreach($ruleFkCampaign as $campaign){
//                 $campaignId=$campaign->getId();
//                 echo $campaignId;
//                 if ($ruleOperator ==">" && isset($ruleValueDate)) {
//                     if ($ruleFieldDeter > $ruleValueDate) {
//                         echo 'echo';
//                         addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface);
//                     }else {
//                         addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface);
//                     }
                    
//                 }

                
//             }
//         }
//     }

// function deterRuleField($ruleFieldEntry, $data){
//         if($ruleFieldEntry == "dob"){
//             $ruleField=$data->getDob();
//             return $ruleField;
//         }
//     }

//     function addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface){
//         $campaignLeads= New CampaignLeads;
//         $fkCampaign=$campaignRepository->find($campaignId);
//         $campaignLeads->setCampaignId($fkCampaign);
//         $campaignLeads->setLeadId($data);
//         $campaignLeads->setStatus("Rejected");
//         $entityManagerInterface->persist($campaignLeads);
//         $entityManagerInterface->flush();
//     }

    
//     function addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface){
//         $campaignLeads= New CampaignLeads;
//         $fkCampaign=$campaignRepository->find($campaignId);
//         $campaignLeads->setCampaignId($fkCampaign);
//         $campaignLeads->setLeadId($data);
//         $campaignLeads->setStatus("Accepted");
//         $entityManagerInterface->persist($campaignLeads);
//         $entityManagerInterface->flush();
//     }

//     function testRules($data){
//         $firstName=$data->getFirstname();
//         if($firstName=='string'){
//             $data->setEmail("jean");
//         }

//     }


function bodyForwarder($forwarderRepository, $lead , $bodyForwarderRepository){
    // $fkCampaign=$campaignRepository->find($campaignId)
    $forwarders=$forwarderRepository->findAll();

     foreach($forwarders as $forwarder){

        $url=$forwarder->getUrl();
        $forwarderId=$forwarder->getId();
        // echo $forwarderId;
        $finalArray=[];

        $bodyForwarders= $bodyForwarderRepository->findBy(['fkForwarder'=>$forwarderId]);
        
        
        foreach ($bodyForwarders as $bodyForwarder) {
            $bodyForwarderInput=$bodyForwarder->getInput();
            $bodyForwarderOutput=$bodyForwarder->getOutpout();
            $bodyForwarderType=$bodyForwarder->getType();
            // var_dump($bodyForwarderType);

            
                    if ($bodyForwarderType=='field') {
                       
                        
                        if ($bodyForwarderInput=='email') {
                        $finalArray[$bodyForwarderOutput]='test';
                        
                        }
                        if ($bodyForwarderInput=='firstname') {

                        $finalArray[$bodyForwarderOutput]='test';
                        
                    }
                  
                }
                if ($bodyForwarderType=="static") {
                    var_dump('test');
                    $finalArray[$bodyForwarderInput]= $bodyForwarderOutput;
                }
                
                
        }
           
        // foreach ($bodyForwarders as $bodyForwarder) {
            
       
        // }

        
        // dump(get_class($bodyForwarderType));
        // var_dump($bodyForwarder);
        // $arrayKeyClient=$forwarder->getBody();
        // $arraysCombine=array_combine($arrayKey, $arrayKeyClient);
        
        // var_dump($arraysCombine);
        
            
            // echo $key . " " . $value .'<br>';
            

        //     if(!empty($arraysCombine['email'])){
                
        //         $finalArray[$arraysCombine['email']]='test';

        //     }
        //     if(!empty($arraysCombine['firstname'])){
                
        //         $finalArray[$arraysCombine['firstname']]='test2';

        //     }
            
        //    if(str_contains($arraysCombine['email'],'static')){

        //    }
        postData($finalArray, $url);        
        var_dump($finalArray);
     }
     
}

function postData($finalArray, $url){
    $client= HttpClient::create();
        $client->request('POST', $url, [
        // defining data using a regular string
        'body' => $finalArray
    ]);
}