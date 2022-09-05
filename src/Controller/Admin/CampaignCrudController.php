<?php

namespace App\Controller\Admin;

use App\Entity\Campaign;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;



class CampaignCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Campaign::class;
        
    }
    public function configureActions(Actions $actions): Actions
    {

        //custom action created to link to the page to add delete rule group
        $detail= Action::new('viewDetails','Rule groups add/delete')
            ->linkToRoute('app_select_rule_group', function (Campaign $campaign): array {
                return [
                    'campaignId' => $campaign->getId(),
                ];
            });
            
        return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_DETAIL, $detail);

    }

    // public function configureFields(string $pageName): iterable
    // {
    //     return [
    //         IdField::new('id')->hideOnForm(),
    //         TextField::new('name'),
    //         TextField::new('client'),
    //         ImageField::new('image')->setUploadDir("public\assets\images"),
    //         CountryField::new('country'),
    //         CurrencyField::new('currency'),
    //         TextField::new('revenuePerLead'),
    //         TextEditorField::new('description'),
    //         AssociationField::new('ruleGroups')
    //         ->autocomplete()
    //         ->onlyOnDetail(),
    //     ];
    // }
    
    
}
