<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\CampaignLeads;
use App\Entity\Leads;
use App\Repository\CampaignLeadsRepository;
use App\Repository\CampaignRepository;
use App\Repository\RuleGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class LeadPersist extends AbstractController

{

    
    
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private  RuleGroupRepository $ruleGroupRepository,
        private EntityManagerInterface $entityManagerInterface,
        private CampaignRepository $campaignRepository,
    )
    {
       
    }
        
    public function __invoke(Leads $data, RuleGroupRepository $ruleGroupRepository, EntityManagerInterface $entityManagerInterface, CampaignRepository $campaignRepository): Leads
    {
        var_dump("I'm in RegisterController");
        $dataId=$data->getEmail();
        var_dump($dataId);
        rulesFunction($ruleGroupRepository, $data, $entityManagerInterface, $campaignRepository);
        var_dump('hey');
        // testRules($data);

        // rulesFunction($ruleGroupRepository, $data, $entityManagerInterface, $campaignRepository);

        return $data;
    }

        // $entityManagerInterface->persist($lead);
        // $entityManagerInterface->flush();

    
    }

    function rulesFunction(RuleGroupRepository $ruleGroupRepository, $data, EntityManagerInterface $entityManagerInterface, CampaignRepository $campaignRepository)
    {
        
        var_dump('jjjjjjjjjjjjjjjjjjjjjjjjjjjj');
        $rules=$ruleGroupRepository->findAll();
        foreach($rules as $rule){
            var_dump('jjjjjjjjjjjjjjjjjjjjjjjjjjjj');
            $ruleName=$rule->getName();
            $ruleFieldEntry=$rule->getField();
            $ruleValue=$rule->getValue();
            $ruleValueDate=$rule->getValueDate();
            $ruleFkCampaign=$rule->getFkCampaign();
            $ruleOperator=$rule->getOperator();
            $ruleFieldDeter=deterRuleField($ruleFieldEntry, $data);
            var_dump('jjjjjjjjjjjjjjjjjjjjjjjjjjjj');
            foreach($ruleFkCampaign as $campaign){
                $campaignId=$campaign->getId();
                echo $campaignId;
                if ($ruleOperator ==">" && isset($ruleValueDate)) {
                    if ($ruleFieldDeter > $ruleValueDate) {
                        echo 'echo';
                        addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface);
                        var_dump('jjjjjjjjjjjjjjjjjjjjjjjjjjjj');
                    }else {
                        addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface);
                    }
                    
                }

                
            }
        }
    }

function deterRuleField($ruleFieldEntry, $data){
        if($ruleFieldEntry == "dob"){
            $ruleField=$data->getDob();
            return $ruleField;
        }
    }

    function addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface){
        $campaignLeads= New CampaignLeads;
        $fkCampaign=$campaignRepository->find($campaignId);
        $campaignLeads->setCampaignId($fkCampaign);
        $campaignLeads->setLeadId($data);
        $campaignLeads->setStatus("Rejected");
        var_dump('hello');
        $entityManagerInterface->persist($campaignLeads);
        $entityManagerInterface->flush();
    }

    
    function addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface){
        $campaignLeads= New CampaignLeads;
        $fkCampaign=$campaignRepository->find($campaignId);
        $campaignLeads->setCampaignId($fkCampaign);
        $campaignLeads->setLeadId($data);
        $campaignLeads->setStatus("Accepted");
        $entityManagerInterface->persist($campaignLeads);
        $entityManagerInterface->flush();
    }