<?php

namespace App\Controller;

use App\Entity\CampaignLeads;
use App\Entity\Leads;
use App\Repository\BodyForwarderRepository;
use App\Repository\CampaignRepository;
use App\Repository\ForwarderRepository;
use App\Repository\LeadsRepository;
use App\Repository\RuleGroupRepository;
use App\Repository\SupplierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Attribute\AsController;


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
    //methode __invoke et Leads $data nécéssaire au bon fonctionnement d'api platform   
    public function __invoke(Leads $data, 
     EntityManagerInterface $entityManagerInterface,
      CampaignRepository $campaignRepository,
      ForwarderRepository $forwarderRepository, 
      BodyForwarderRepository $bodyForwarderRepository,
      SupplierRepository $supplierRepository,
      LeadsRepository $leadRepository
      ): Leads
    {
       
        dataProcessing($data, $entityManagerInterface, $campaignRepository, $forwarderRepository,
        $bodyForwarderRepository, $supplierRepository, $leadRepository);

        return $data;
    }

}
function dataProcessing($data, 
    $entityManagerInterface, 
    $campaignRepository,
    $forwarderRepository,
    $bodyForwarderRepository,
    $supplierRepository,$leadRepository
    )
    {

        //sid indentical for all the campaign 
        $supplierId=$data->getSid();
        $emailUser= $data->getEmail();
        $campaignId=1;
        if(isEmailExist($emailUser, $leadRepository) != false){
            addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId);
            exit;
        };
        $campaigns=$campaignRepository->findAll();

        //getting all the rules for all the campaigns
        foreach($campaigns as $campaign){
            $CampaignRules=$campaign->getRuleGroups();
            $campaignId=$campaign->getId();
            
        foreach($CampaignRules as $rule){

            $ruleFieldEntry=$rule->getField();
            $ruleValue=$rule->getValue();
            $ruleValueDate=$rule->getValueDate();
            $ruleOperator=$rule->getOperator();
            // select the right field on wich the value of the rule must be compared 
            $ruleFieldDeter=deterRuleField($ruleFieldEntry, $data);
            //if email is already in db then status is automaticly rejected
            // determine if the value is of type date or string
                if (isset($ruleValueDate)) {
            //function to select the right operator
                    dateValueRules($ruleFieldDeter, $ruleOperator, $ruleValueDate, $campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository, $supplierRepository, $supplierId);
                }elseif(isset($ruleValue)){
                    textValueRules($ruleFieldDeter, $ruleOperator, $ruleValue, $campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository, $supplierRepository, $supplierId);
                }else{
                    addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository, $supplierRepository, $supplierId);
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
 //add status rejected
    function addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId){
        //create the new campaign and get the proper campaign and supllier via the ids in the data
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

    //add the accepted status and forward the leads
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
        forwarder($forwarderRepository, $campaignId, $data, $bodyForwarderRepository,$campaignLeads, $entityManagerInterface);
    }

function forwarder($forwarderRepository, $campaignId, $data, $bodyForwarderRepository,$campaignLeads,$entityManagerInterface){
        $forwarders=$forwarderRepository->findBy(['fkCampaign' =>$campaignId]);
        foreach($forwarders as $forwarder){
            $url=$forwarder->getUrl();
            $forwarderId=$forwarder->getId();
            $headerArray=[];
            $finalArray=[];
            $bodyForwarders= $bodyForwarderRepository->findBy(['fkForwarder'=>$forwarderId]);

            // foreach forwarder i get the data corresponding to the field registered in the forwarder
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
                                case 'ip':
                                        $finalArray[$bodyForwarderOutput]=$data->getIp();
                                        break;
                                case 'region':
                                        $finalArray[$bodyForwarderOutput]=$data->getRegion();
                                        break;
                                case 'sex':
                                    $finalArray[$bodyForwarderOutput]=$data->getSex();
                                        break;
                                case 'phone':
                                    $finalArray[$bodyForwarderOutput]=$data->getPhone();
                                        break;
                                default:
                                    break;
                            }
                    }
                    if ($bodyForwarderType=="static") {
                        $finalArray[$bodyForwarderInput]= $bodyForwarderOutput;
                    }     
                    if ($bodyForwarderType=="header") {
                        $headerArray[$bodyForwarderInput]= $bodyForwarderOutput;
                    }     
            }
            postData($finalArray,$headerArray, $url, $campaignLeads, $entityManagerInterface);
        }  
    }
//switch for the different operators Date
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
//switch for the different operators Text
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
                    addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository,$supplierRepository, $supplierId);        
                }else {
                    addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository,$supplierId);     
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
            case 'contains':
                    if (str_contains($ruleFieldDeter, $ruleValue)) {
                        addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $forwarderRepository, $bodyForwarderRepository,$supplierRepository, $supplierId);
                    }else {
                        
                        addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId);
                    }
                    break;
        default:
            break;
    }
    
}
function postData($finalArray,$headerArray, $url, $campaignLeads, $entityManagerInterface){
    $client= HttpClient::create();
    
    $response=$client->request('POST', $url, [
        'headers'=> $headerArray,   
        'body' => $finalArray
    ]);
    //get infos of the response to see if the datas wher sent properly
    $statusCode = $response->getStatusCode();
    $contentType = $response->getHeaders()['content-type'][0];
    $content = $response->getContent();
    if ($statusCode != 201 && $statusCode != 200 ) {
        $campaignLeads->setStatus("Client rejected");
        $entityManagerInterface->flush();
    }
}

function isEmailExist(string $emailUser, $leadRepository): bool
{
    // search for an existing email in db
    $emailInDB= $leadRepository->findOneBy(['email' => $emailUser]);

    if (!empty($emailInDB)) {
        return true;
    }
    return false;
}