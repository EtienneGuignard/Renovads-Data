<?php

namespace App\Controller\Admin;

use App\Entity\Campaign;
use App\Repository\CampaignRepository;
use App\Repository\RuleGroupRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CampaignCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Campaign::class;
    }
    public function configureActions(Actions $actions): Actions
    {

        $detailTest= Action::new('viewDetails','show')
            ->linkToRoute('app_select_rule_group', function (Campaign $campaign): array {
                return [
                    'campaignId' => $campaign->getId(),
                ];
            });;
        return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_DETAIL, $detailTest);

    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
    // #[Route('/select/rule/group/', name: 'app_add_rule_group')]
    // public function formSelectRule(RuleGroupRepository $ruleGroupRepository, CampaignRepository $campaignRepository): Response
    // {

    //     if(isset($_POST['ruleId'])){
    //         $campaignId=$_POST['campaignId'];
    //         $ruleGroupId=$_POST['ruleId'];
    //         $ruleGroup=$ruleGroupRepository->find($ruleGroupId);
    //         $campaign=$campaignRepository->find($campaignId);
    //         $campaign->getRuleGroups()->add($ruleGroup);
    //         $ruleGroup->getFkCampaign()->add($campaign);
    //     }
    //     return $this->render('$0.html.twig', []);
    // }
}
