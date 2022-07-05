<?php

namespace App\Controller;

use App\Entity\RuleGroup;
use App\Repository\RuleGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SelectRuleGroupController extends AbstractController
{
    #[Route('/select/rule/group', name: 'app_select_rule_group')]
    public function index(RuleGroupRepository $ruleGroupRepository): Response
    {
        $rulesGroup=$ruleGroupRepository->findAll();
        return $this->render('select_rule_group/index.html.twig', [
            'controller_name' => 'SelectRuleGroupController',
            'rules'  =>$rulesGroup
        ]);
    }
}
