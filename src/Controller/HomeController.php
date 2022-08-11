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
    

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            
            
        ]);
    }
}
