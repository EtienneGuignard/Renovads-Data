<?php

namespace App\Controller\Admin;

use App\Entity\Campaign;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
            });
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
}
