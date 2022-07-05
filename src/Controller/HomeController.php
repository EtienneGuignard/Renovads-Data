<?php

namespace App\Controller;

use App\Entity\CampaignLeads;
use App\Entity\Leads;
use App\Entity\RuleGroup;
use App\Form\LeadsType;
use App\Repository\CampaignRepository;
use App\Repository\LeadsRepository;
use App\Repository\RuleGroupRepository;
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
    RuleGroupRepository $ruleGroupRepository
    ): Response
    {
    
        
        $lead= new Leads;
        $form= $this->createForm(LeadsType::class, $lead);
        $form->handleRequest($request);
        $campaigns= $campaignRepository->findAll();
        foreach ($campaigns as $campaign){
            $campaignId=$campaign->getId();
            echo $campaignId;
        };
        


        if ($form->isSubmitted() && $form->isValid()) { 

            $email= $lead->getEmail();
            $fisrtname= $lead->getFirstname();
            echo $fisrtname;
            
            // postData($email, $fisrtname);
            
            $entityManagerInterface->persist($lead);
            $entityManagerInterface->flush();
            rulesFunction($ruleGroupRepository, $lead, $entityManagerInterface, $campaignRepository);
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form'=> $form->createView(),
            
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

function rulesFunction(RuleGroupRepository $ruleGroupRepository, $lead, $entityManagerInterface, $campaignRepository)
    {
        $rules=$ruleGroupRepository->findAll();
        foreach($rules as $rule){
            $ruleName=$rule->getName();
            $ruleField=$lead->getDob();
            $ruleOperator=$rule->getOperator();
            $ruleValue=$rule->getValue();
            $ruleFkCampaign=$rule->getFkCampaign();
            echo $ruleName;
            // $ruleFkCampaignId=$ruleFkCampaign->getId();
            foreach($ruleFkCampaign as $campaign){
                $campaignId=$campaign->getId();
                echo $campaignId;
                if ($ruleOperator ==">") {
                    if ($ruleField> $ruleValue) {
                        addStatus($campaignRepository, $campaignId, $lead, $entityManagerInterface);
                    }
                    
                }
                
            }
        }
    }

    function addStatus($campaignRepository, $campaignId, $lead, $entityManagerInterface){
        $campaignLeads= New CampaignLeads;
        $fkCampaign=$campaignRepository->find($campaignId);
        $campaignLeads->setCampaignId($fkCampaign);
        $campaignLeads->setLeadId($lead);
        // $lead->getFkLeads()->add($campaignLeads);
        
        
        $campaignLeads->setStatus("Rejected");
        $entityManagerInterface->persist($campaignLeads);
        $entityManagerInterface->flush();
    }