<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\RuleGroup;
use App\Repository\CampaignRepository;
use App\Repository\RuleGroupRepository;
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
    public function index(RuleGroupRepository $ruleGroupRepository, CampaignRepository $campaignRepository, $campaignId): Response
    {
        $rulesGroup=$ruleGroupRepository->findAll();
        
            $routeParam=$_GET['routeParams'];
            $campaignId=$routeParam['campaignId'];
            $referUrl='http://127.0.0.1:8000/' . $_GET['referrer'];
        
    

   

        return $this->render('select_rule_group/index.html.twig', [
            'rules'  =>$rulesGroup,
            'campaignId'=>$campaignId
        ]);
    }
}
