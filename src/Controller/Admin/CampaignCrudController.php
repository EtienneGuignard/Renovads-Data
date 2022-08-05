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

        $detail= Action::new('viewDetails','Add new rule group')
            ->linkToRoute('app_select_rule_group', function (Campaign $campaign): array {
                return [
                    'campaignId' => $campaign->getId(),
                ];
            });;
        return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_DETAIL, $detail);

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
}
