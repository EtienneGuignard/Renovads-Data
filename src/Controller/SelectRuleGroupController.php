<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\RuleGroup;
use App\Repository\CampaignRepository;
use App\Repository\RuleGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SelectRuleGroupController extends AbstractController
{
    public function __construct(
        

    )
    {
    
    } 
    
    #[Route('/select/rule/group/', name: 'app_select_rule_group')]
    public function index(RuleGroupRepository $ruleGroupRepository, EntityManagerInterface $entityManagerInterface, CampaignRepository $campaignRepository): Response
    {
        $rulesGroup=$ruleGroupRepository->findAll();
        
            
            if (isset($_GET['routeParams'])) {
                $routeParam=$_GET['routeParams'];
                $campaignId=$routeParam['campaignId'];
                $referUrl='http://127.0.0.1:8000' . $_GET['referrer'];
            echo $referUrl;
            }

            
        
        if(isset($_POST['ruleId'])){
            $campaignId=$_POST['campaignId'];
            $ruleGroupId=$_POST['ruleId'];
            $referUrl=$_POST['refer'];
            $ruleGroup=$ruleGroupRepository->find($ruleGroupId);
            $campaign=$campaignRepository->find($campaignId);
            $campaign->getRuleGroups()->add($ruleGroup);
            $ruleGroup->getFkCampaign()->add($campaign);
            $entityManagerInterface->persist($campaign);
            $entityManagerInterface->flush();

            return $this->redirect($referUrl);
        }

   

        return $this->render('select_rule_group/index.html.twig', [
            'rules'  =>$rulesGroup,
            'campaignId'=>$campaignId,
            'refer' => $referUrl
        ]);
    }
}
