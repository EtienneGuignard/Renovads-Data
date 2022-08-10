<?php

namespace App\Controller;

use App\Entity\BodyForwarder;
use App\Entity\Campaign;
use App\Entity\CampaignLeads;
use App\Entity\Forwarder;
use App\Entity\Leads;
use App\Entity\Supplier;
use App\Repository\BodyForwarderRepository;
use App\Repository\CampaignLeadsRepository;
use App\Repository\CampaignRepository;
use App\Repository\ForwarderRepository;
use App\Repository\RuleGroupRepository;
use App\Repository\SupplierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\New_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
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
    public function __invoke(Leads $data, 
    RuleGroupRepository $ruleGroupRepository,
     EntityManagerInterface $entityManagerInterface,
      CampaignRepository $campaignRepository,
      ForwarderRepository $forwarderRepository, 
      BodyForwarderRepository $bodyForwarderRepository,
      SupplierRepository $supplierRepository,
      ): Leads
    {
        dataProcessing($ruleGroupRepository, $data, $entityManagerInterface, $campaignRepository, $forwarderRepository, $bodyForwarderRepository, $supplierRepository);

        return $data;
    }
}

    function dataProcessing(RuleGroupRepository $ruleGroupRepository, $data, 
    EntityManagerInterface $entityManagerInterface, 
    CampaignRepository $campaignRepository,
    $forwarderRepository,
    $bodyForwarderRepository,
    $supplierRepository,
    )
    {
        $supplierId=$data->getSid();
        
        if (isset($supplierId)) {
            
        }else{
            $supplierId=1; 
        }
       
        
        $rules=$ruleGroupRepository->findAll();
        foreach($rules as $rule){

            $ruleFieldEntry=$rule->getField();
            $ruleValue=$rule->getValue();
            $ruleValueDate=$rule->getValueDate();
            $ruleFkCampaign=$rule->getFkCampaign();
            $ruleOperator=$rule->getOperator();
            $ruleFieldDeter=deterRuleField($ruleFieldEntry, $data);
            foreach($ruleFkCampaign as $campaign){
                $campaignId=$campaign->getId();
                if (isset($ruleValueDate)) {
                    dateValueRules($ruleFieldDeter, $ruleOperator, $ruleValueDate, $campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository, $supplierRepository, $supplierId);
                }else{
                    textValueRules($ruleFieldDeter, $ruleOperator, $ruleValue, $campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository, $supplierRepository, $supplierId);
                }
                
            }
        }
    }

function deterRuleField($ruleFieldEntry, $data){

    switch ($ruleFieldEntry) {
        case 'dob':
            $ruleField=$data->getDob();
            return $ruleField;
            break;
        case 'zip':
            $ruleField=$data->getZip();
            return $ruleField;
            break;
        case 'email':
            $ruleField=$data->getEmail();
            return $ruleField;
            break;
        case 'confirmPrivacy':
            $ruleField=$data->getConfirmPrivacy();
            return $ruleField;
            break;
        case 'confirmPartners':
            $ruleField=$data->getConfirmPartners();
            return $ruleField;
            break;
        case 'job':
            $ruleField=$data->getJob();
            return $ruleField;
            break;
        case 'children':
            $ruleField=$data->getChildren();
            return $ruleField;
            break;
        default:
            break;
    }
    }

    function addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId){
        $campaignLeads= New CampaignLeads;
        $fksupplier=$supplierRepository->find($supplierId);
        $fkCampaign=$campaignRepository->find($campaignId);
        $data->setSupplier($fksupplier);
        $campaignLeads->setCampaignId($fkCampaign);
        $campaignLeads->setLeadId($data);
        $campaignLeads->setStatus("Rejected");
        $entityManagerInterface->persist($campaignLeads);
        $entityManagerInterface->flush();
    }

    
    function addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository, $supplierRepository, $supplierId){
        $campaignLeads= New CampaignLeads;
        $fkCampaign=$campaignRepository->find($campaignId);
        $fksupplier=$supplierRepository->find($supplierId);
        $data->setSupplier($fksupplier);
        $campaignLeads->setCampaignId($fkCampaign);
        $campaignLeads->setLeadId($data);
        $campaignLeads->setStatus("Accepted");
        $entityManagerInterface->persist($campaignLeads);
        $entityManagerInterface->flush();
        forwarder($forwarderRepository, $data , $bodyForwarderRepository);
    }

    function forwarder($forwarderRepository, $data , $bodyForwarderRepository){
        $forwarders=$forwarderRepository->findAll();
         foreach($forwarders as $forwarder){
    
            $url=$forwarder->getUrl();
            $forwarderId=$forwarder->getId();
            $finalArray=[];
            $bodyForwarders= $bodyForwarderRepository->findBy(['fkForwarder'=>$forwarderId]);
             
            foreach ($bodyForwarders as $bodyForwarder) {
                $bodyForwarderInput=$bodyForwarder->getInput();
                $bodyForwarderOutput=$bodyForwarder->getOutpout();
                $bodyForwarderType=$bodyForwarder->getType();
                        if ($bodyForwarderType=='field') {
                            switch ($bodyForwarderInput) {
                                case 'email':
                                    $finalArray[$bodyForwarderOutput]=$data->getEmail();
                                    break;
                                case 'firstname':
                                    $finalArray[$bodyForwarderOutput]=$data->getFirstname();
                                    break;
                                case 'lastname':
                                    $finalArray[$bodyForwarderOutput]=$data->getLastname();
                                    break;
                                case 'dob':
                                    $finalArray[$bodyForwarderOutput]=$data->getDob();
                                    break;
                                case 'address_1':
                                    $finalArray[$bodyForwarderOutput]=$data->geAddress1();
                                    break;
                                case 'address_2':
                                    $finalArray[$bodyForwarderOutput]=$data->getAddress2();
                                    break;
                                case 'city':
                                    $finalArray[$bodyForwarderOutput]=$data->getCity();
                                    break;
                                case 'zip':
                                    $finalArray[$bodyForwarderOutput]=$data->getZip();
                                    break;
                                case 'url':
                                     $finalArray[$bodyForwarderOutput]=$data->getUrl();
                                     break;
                                case 'job':
                                        $finalArray[$bodyForwarderOutput]=$data->getJob();
                                     break;
                                case 'family':
                                        $finalArray[$bodyForwarderOutput]=$data->getChildren();
                                     break;
                                case 'created_at':
                                        $finalArray[$bodyForwarderOutput]=$data->getCreatedAt();
                                        break;
                                default:
                                    break;
                            }
                    }
                    if ($bodyForwarderType=="static") {
                        var_dump('test');
                        $finalArray[$bodyForwarderInput]= $bodyForwarderOutput;
                    }     
            }
            postData($finalArray, $url);
         }  
    }

function dateValueRules($ruleFieldDeter, $ruleOperator, $ruleValueDate, $campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository, $supplierRepository, $supplierId){
    switch ($ruleOperator) {
        case '>':
            if ($ruleFieldDeter > $ruleValueDate) {
                addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository, $supplierRepository, $supplierId);  
            }else {
                addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId);
            }
            break;
        case '<':
            if ($ruleFieldDeter < $ruleValueDate) {
                addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository, $supplierRepository, $supplierId);
            }else {
                addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId);
            }
            break;
        case '==':
            if ($ruleFieldDeter === $ruleValueDate) {
                addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository, $supplierRepository, $supplierId); 
            }else {
                addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId);
            }
            break;
        
        default:
            break;
    }
    
}

function textValueRules($ruleFieldDeter, $ruleOperator, $ruleValue, $campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository,$supplierRepository, $supplierId){
    switch ($ruleOperator) {
        case '>':
            if (strlen($ruleFieldDeter) > strlen($ruleValue)) {
                addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository,$supplierRepository, $supplierId);
            }else {
                addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId);
            }
            break;
        case '<':
            if (strlen($ruleFieldDeter) < strlen($ruleValue)) {
                addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository,$supplierRepository, $supplierId);
            }else {
                addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId);
            }
            break;
        case '==':
            if ($ruleFieldDeter === $ruleValue) {
                addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository,$supplierRepository, $supplierId);  
            }else {
                addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId);
            }
            break;
            case '!=':
                if ($ruleFieldDeter != $ruleValue) {
                    addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId);            
                }else {
                    addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository,$supplierRepository, $supplierId); 
                }
                break;
            case 'notempty':
                if (!empty($ruleFieldDeter)) {
                    addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository,$supplierRepository, $supplierId);
                }else {
                    addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId);
                }
                break;
            case 'true':
                if ($ruleFieldDeter==true) {
                    addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository,$supplierRepository, $supplierId);
                    
                }else {
                    addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId);
                }
                break;
             case 'false':
                if ($ruleFieldDeter==false) {
                    addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository,$supplierRepository, $supplierId);
                }else {
                    
                    addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId);
                }
                break;
        default:
            break;
    }
    
}
function postData($finalArray, $url){
    $client= HttpClient::create();
        $client->request('POST', $url, [
        'body' => $finalArray
    ]);
}