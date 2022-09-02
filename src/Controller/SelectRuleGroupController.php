<?php

namespace App\Controller;

use App\Controller\Admin\CampaignCrudController;
use App\Controller\Admin\LeadsCrudController;
use App\Entity\ApiToken;
use App\Entity\Campaign;
use App\Entity\Forwarder;
use App\Entity\Leads;
use App\Entity\RuleGroup;
use App\Entity\Supplier;
use App\Entity\User;
use App\Repository\CampaignRepository;
use App\Repository\RuleGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SelectRuleGroupController extends AbstractDashboardController
{
    public function __construct(
        

    )
    {
    
    } 
    
    #[Route('/select/rule/group/{campaignId}', name: 'app_select_rule_group')]
    public function indexSelect(RuleGroupRepository $ruleGroupRepository, EntityManagerInterface $entityManagerInterface, 
    CampaignRepository $campaignRepository, 
    int $campaignId
    ): Response
    {
        $rulesGroup=$ruleGroupRepository->findAll();
        
            
            if (isset($_GET['routeParams'])) {
                $routeParam=$_GET['routeParams'];
                $campaignId=$routeParam['campaignId'];
                $referUrl='http://127.0.0.1:8000' . $_GET['referrer'];
                $ruleGroupList = $ruleGroupRepository->ruleList($entityManagerInterface, $campaignId);


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
        
        $ruleGroupList=$ruleGroupRepository->ruleList($entityManagerInterface, $campaignId);
        // check if form is submitted and persist+flush the selected rulegroup

        if(isset($_POST['submit'])){

            $ruleGroupId=$_POST['ruleId'];
           
            $ruleGroup=$ruleGroupRepository->find($ruleGroupId);
            $campaign=$campaignRepository->find($campaignId);
            $campaign->getRuleGroups()->add($ruleGroup);
            $ruleGroup->getFkCampaign()->add($campaign);
            $entityManagerInterface->persist($campaign);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_select_rule_group', ['campaignId'=>$campaignId]);
        }

   

        return $this->render('select_rule_group/index.html.twig', [
            'ruleGroupList'=>$ruleGroupList,
            'rules'  =>$rulesGroup,
            'campaignId'=>$campaignId,
        ]);
    }

    #[Route('/select/rule/group/add/{campaignId}', name: 'app_select_rule_group_add')]
    public function AddRule(RuleGroupRepository $ruleGroupRepository, EntityManagerInterface $entityManagerInterface, 
    CampaignRepository $campaignRepository, 
    int $campaignId
    ): Response
    {
        if(isset($_POST['submit'])){

            $ruleGroupId=$_POST['ruleId'];
            $ruleGroup=$ruleGroupRepository->find($ruleGroupId);
            $campaign=$campaignRepository->find($campaignId);
            $campaign->getRuleGroups()->add($ruleGroup);
            $ruleGroup->getFkCampaign()->add($campaign);
            $entityManagerInterface->persist($campaign);
            $entityManagerInterface->flush();

            
        }
        return $this->redirectToRoute('app_select_rule_group', ['campaignId'=>$campaignId]);
    }


    #[Route('/select/rule/delete/{id}/{ruleId}', name: 'delete_campaign_rule')]
    public function deleteUser(
    EntityManagerInterface $entityManagerInterface,
    CampaignRepository $campaignRepository,
    RuleGroupRepository $ruleGroupRepository ,
    Campaign $campaign,
    int $id,
    int $ruleId
    ): Response 
{  
            $campaign=$campaignRepository->find($id);
            $ruleGroup=$ruleGroupRepository->find($ruleId);
            $campaign->removeRuleGroup($ruleGroup);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_select_rule_group', ['campaignId'=>$id]);
        
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