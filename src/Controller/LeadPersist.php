<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\CampaignLeads;
use App\Entity\Leads;
use App\Repository\BodyForwarderRepository;
use App\Repository\CampaignLeadsRepository;
use App\Repository\CampaignRepository;
use App\Repository\DataAcrossHeaderRepository;
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
      LeadsRepository $leadRepository,
      CampaignLeadsRepository $campaignLeadsRepository,
      DataAcrossHeaderRepository $dataAcrossHeaderRepository,

      ): Leads
    {

            dataProcessing($data, $entityManagerInterface, $campaignRepository, $forwarderRepository,
            $bodyForwarderRepository, $supplierRepository, $leadRepository, $campaignLeadsRepository, $dataAcrossHeaderRepository);


        return $data;
    }

}
function dataProcessing($data, 
    $entityManagerInterface, 
    $campaignRepository,
    $forwarderRepository,
    $bodyForwarderRepository,
    $supplierRepository,
    $leadRepository,
    $campaignLeadsRepository,
    $dataAcrossHeaderRepository
    )
    {
        //sid indentical for all the campaign 
        $supplierId=$data->getSid();
        $emailUser= $data->getEmail();
       
        $campaignLeads='';
        $campaignId=1;
        // if(isEmailExist($emailUser, $leadRepository) != false){
        //     var_dump('Duplicate');
        //     addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId , $campaignLeads, $campaignLeadsRepository);
        //     exit;
        // };
        $cidDB=$data->getCid();
      
        if (!empty($cidDB)) {
            $campaignId=$cidDB;
            $campaigns=[$campaignRepository->find($campaignId)];
            
        }else{
            $campaigns=$campaignRepository->findAll();
        }
   
        //getting all the rules for all the campaigns
        
        foreach($campaigns as $campaign){

            
            $CampaignRules=$campaign->getRuleGroups();
            $campaignId=$campaign->getId();  
            $client=$campaign->getClient();

            if ($client=="across") {
                
                $dataAcrossHeader=$dataAcrossHeaderRepository->findOneBy(['campaignId' => $campaignId]);
                if ($dataAcrossHeader) {
                    forwarder($forwarderRepository, $campaignId, $data, $bodyForwarderRepository, $client, $dataAcrossHeader, $supplierId, $supplierRepository, $campaignRepository, $entityManagerInterface);
                }      
            }         
            if ($client!="across") {
                foreach($CampaignRules as $rule){
                    $lead=$campaignLeadsRepository->campaignLeadExistPerEmail($emailUser, $campaignId, $entityManagerInterface);
                    if (!empty($lead)) {  
                        $leadId=$lead[0]['id']; 
                        $campaignLeads= $campaignLeadsRepository->find($leadId); 

                    }
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
                            dateValueRules($ruleFieldDeter, $ruleOperator, 
                            $ruleValueDate, $campaignRepository, $campaignId,
                            $data, $entityManagerInterface, $supplierRepository, $supplierId , $campaignLeads, $campaignLeadsRepository);
                        }elseif(isset($ruleValue)){
                            textValueRules($ruleFieldDeter, $ruleOperator, $ruleValue, 
                            $campaignRepository, $campaignId, $data, $entityManagerInterface,  
                            $supplierRepository, $supplierId, $campaignLeads, $campaignLeadsRepository);
                        }else{
                            addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface,
                            $forwarderRepository, $supplierRepository, $supplierId, $campaignLeads, $campaignLeadsRepository);
                        }
                    }
                    $lead=$campaignLeadsRepository->campaignLeadExistPerEmail($emailUser, $campaignId, $entityManagerInterface);
                    $leadId=$lead[0]['id'];
                    $campaignLeads= $campaignLeadsRepository->find($leadId);
                 
                    if ($campaignLeads->getStatus()=='Accepted') {
                        forwarder($forwarderRepository, $campaignId, $data, $bodyForwarderRepository,$campaignLeads, $entityManagerInterface,$client, $dataAcrossHeader, $supplierId, $supplierRepository, $campaignRepository, $entityManagerInterface);
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
    function addStatusRejected($campaignRepository, $campaignId, $data, 
    $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads){
        //create the new campaign and get the proper campaign and supllier via the ids in the data      
        if (!empty($campaignLeads)) {
            $campaignLeads->setStatus("Rejected");
            $campaignLeads->setTimestamp($data->getCreatedAt());
            $entityManagerInterface->flush();
        }else {
            $campaignLeads= New CampaignLeads;
            $timestampWrongFormat=$data->getCreatedAt();
            $fksupplier=$supplierRepository->find($supplierId);
            $fkCampaign=$campaignRepository->find($campaignId);
            $data->setSupplier($fksupplier);
            $campaignLeads->setCampaignId($fkCampaign);
            $campaignLeads->setLeadId($data);
            $campaignLeads->setTimestamp($timestampWrongFormat);
            $campaignLeads->setStatus("Rejected");
            $entityManagerInterface->persist($campaignLeads);
            $entityManagerInterface->flush();
        }
       
       
    }

    //add the accepted status and forward the leads
function addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId,  $campaignLeads){
  

    if (!empty($campaignLeads)) {
            $campaignLeads->setStatus("Acctepted");
            $campaignLeads->setTimestamp($data->getCreatedAt());
            $entityManagerInterface->flush();
    }else {
        $campaignLeads= New CampaignLeads;
        $fkCampaign=$campaignRepository->find($campaignId);
        $fksupplier=$supplierRepository->find($supplierId);
        $data->setSupplier($fksupplier);
        $campaignLeads->setCampaignId($fkCampaign);
        $campaignLeads->setLeadId($data);
        $campaignLeads->setTimestamp($data->getCreatedAt());
        $campaignLeads->setStatus("Accepted");
        $entityManagerInterface->persist($campaignLeads);
        $entityManagerInterface->flush();
    } 
      
    }

function forwarder($forwarderRepository, $campaignId, $data, $bodyForwarderRepository, $client,
$dataAcrossHeader, $supplierId, $supplierRepository, $campaignRepository, $entityManagerInterface){

        $forwarders=$forwarderRepository->findBy(['fkCampaign' =>$campaignId]);
        foreach($forwarders as $forwarder){

            $forwarderId=$forwarder->getId();
            $headerArray=[];
            $finalArray=[];
            
            $bodyForwarders= $bodyForwarderRepository->findBy(['fkForwarder'=>$forwarderId]);
            
            if (!empty($bodyForwarders)) {
           
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
                                        $finalArray[$bodyForwarderOutput]=date_format($data->getDob(), 'Y-m-d');
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
                                            $finalArray[$bodyForwarderOutput]=date_format($data->getCreatedAt(), 'Y-m-d H:i:s');
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
                                    case 'age':
                                        $finalArray[$bodyForwarderOutput]=$data->getAge();
                                            break;
                                    case 'paramInfo1':
                                        $finalArray[$bodyForwarderOutput]=$data->getParamInfo1();
                                            break;
                                    case 'paramInfo2':
                                        $finalArray[$bodyForwarderOutput]=$data->getParamInfo2();
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
                if ($client=='across') {
                    postDataAcrossDating( $data, $dataAcrossHeader, $campaignId, $supplierId, $supplierRepository, $campaignRepository, $entityManagerInterface, $finalArray);
                }
                // postData($finalArray,$headerArray, $url, $campaignLeads, $entityManagerInterface);
            }  
        }
    }
//switch for the different operators Date
function dateValueRules( $ruleFieldDeter, $ruleOperator, 
$ruleValueDate, $campaignRepository, $campaignId,
$data, $entityManagerInterface, $supplierRepository, $supplierId , $campaignLeads, $campaignLeadsRepository){

    switch ($ruleOperator) {
        case '>':
            if ($ruleFieldDeter > $ruleValueDate) {
                addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads, $campaignLeadsRepository);  
            }else {
                addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads, $campaignLeadsRepository);
            }
            break;
        case '<':
            if ($ruleFieldDeter < $ruleValueDate) {
                
                addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads, $campaignLeadsRepository);
            }else {
                addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads, $campaignLeadsRepository);
            }
            break;
        case '==':
            if ($ruleFieldDeter === $ruleValueDate) {
                addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads, $campaignLeadsRepository); 
            }else {
                addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId, $campaignLeads, $campaignLeadsRepository);
            }
            break;
        
        default:
            break;
    }
    
}
//switch for the different operators Text
function textValueRules($ruleFieldDeter, $ruleOperator, $ruleValue, $campaignRepository, 
$campaignId, $data, $entityManagerInterface, 
$supplierRepository, $supplierId, $campaignLeads){
    switch ($ruleOperator) {
        case '>':
            if (strlen($ruleFieldDeter) > strlen($ruleValue)) {
                addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads);
            }else {
                addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads);
            }
            break;
        case '<':
            if (strlen($ruleFieldDeter) < strlen($ruleValue)) {
                addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads);
            }else {
                addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId, $campaignLeads);
            }
            break;
        case '==':
            if ($ruleFieldDeter === $ruleValue) {
                addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads);  
            }else {
                addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId, $campaignLeads);
            }
            break;
            case '!=':
                if ($ruleFieldDeter != $ruleValue) {
                    addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId, $campaignLeads);            
                }else {
                    addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads);
                }
                break;
            case 'notem':
                if (!empty($ruleFieldDeter)) {
                    addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads);
                }else {
                    addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId, $campaignLeads);
                }
                break;
            case 'true':
                if ($ruleFieldDeter==true) {
                    addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads);
                    
                }else {
                    addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId, $campaignLeads);
                }
                break;
            case 'false':
                if ($ruleFieldDeter==false) {
                    addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads);
                }else {
                    
                    addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId, $campaignLeads);
                }
                break;
            case 'conta':
                    if (str_contains($ruleFieldDeter, $ruleValue)) {
                        addStatusAccepted($campaignRepository, $campaignId, $data, $entityManagerInterface, $supplierRepository, $supplierId, $campaignLeads);
                    }else {
                        
                        addStatusRejected($campaignRepository, $campaignId, $data, $entityManagerInterface,$supplierRepository, $supplierId, $campaignLeads);
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

function postDataAcrossDating( $data, $dataAcrossHeader, $campaignId, $supplierId, $supplierRepository, $campaignRepository, $entityManagerInterface, $finalArray){
    var_dump($campaignId);
    $timestampWrongFormat=$data->getCreatedAt();
    $idProgramma=$dataAcrossHeader->getIdProgramma();
    $url=$dataAcrossHeader->getUrl();
    $encoding = 'sha256';
    $identifier = 'ZTN';
    $secret = $dataAcrossHeader->getSecret();
    var_dump($secret);
    $method = 'POST';
    $uri = $dataAcrossHeader->getUri();
    $body=json_encode($finalArray);
    
    $time = time();
    $signature = $time . $method . $uri . md5(json_encode($finalArray, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    $digest = hash_hmac($encoding, $signature, $secret);
    $auth = "Authorization: $identifier $time:$digest";

    $header=[$auth,   'Accept: application/json', 'Content-Type: application/json'  ];
 

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_POSTFIELDS => $body,
      CURLOPT_HTTPHEADER => $header,
    ));
    echo $method . ' ' . $uri . 'HTTP/1.1' . "\r\n";
    echo "host: $url \r\n";
    echo "$header[0] \r\n";
    echo "$header[1] \r\n";
    echo "$header[2] \r\n";
    echo "$body \r\n";

  
    $response = curl_exec($curl);
    curl_close($curl);

    if (!str_contains($response, '"status":"OK"')) {
       
        echo $response . "\r\n";
        setCampaignleadRejectedAcross($data, $campaignId, $supplierId, $supplierRepository, $campaignRepository, $entityManagerInterface, $timestampWrongFormat, $response);
    }
    if (str_contains($response, '"status":"OK"')) {
       echo $response . "\r\n";
        setCampaignleadAccepted($data, $campaignId, $supplierId, $supplierRepository, $campaignRepository, $entityManagerInterface,$timestampWrongFormat, $response);
    } 

}
function setCampaignleadAccepted($data, $campaignId, $supplierId, $supplierRepository, $campaignRepository, $entityManagerInterface, $timestampWrongFormat, $response){
    $campaignLeads= New CampaignLeads;
    $fkCampaign=$campaignRepository->find($campaignId);
    $fksupplier=$supplierRepository->find($supplierId);
    $data->setSupplier($fksupplier);
    $campaignLeads->setCampaignId($fkCampaign);
    $campaignLeads->setLeadId($data);
    $campaignLeads->setStatus("Accepted");
    $campaignLeads->setTimestamp($timestampWrongFormat);
    $campaignLeads->setResponseForwarding($response);
    $entityManagerInterface->persist($campaignLeads);
    $entityManagerInterface->flush();

}
function setCampaignleadRejectedAcross($data, $campaignId, $supplierId, $supplierRepository, $campaignRepository, $entityManagerInterface, $timestampWrongFormat, $response){
    $campaignLeads= New CampaignLeads;
    $fkCampaign=$campaignRepository->find($campaignId);
    $fksupplier=$supplierRepository->find($supplierId);
    $data->setSupplier($fksupplier);
    $campaignLeads->setCampaignId($fkCampaign);
    $campaignLeads->setLeadId($data);
    $campaignLeads->setStatus("Rejected Across");
    $campaignLeads->setTimestamp($timestampWrongFormat);
    $campaignLeads->setResponseForwarding($response);
    $entityManagerInterface->persist($campaignLeads);
    $entityManagerInterface->flush();
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


