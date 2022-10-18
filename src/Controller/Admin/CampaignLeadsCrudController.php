<?php

namespace App\Controller\Admin;

use App\Entity\CampaignLeads;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CampaignLeadsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CampaignLeads::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('status'),
            AssociationField::new('leadId', 'Lead email')->autocomplete(),
            AssociationField::new('campaignId', 'Campaign')->autocomplete(),
            DateTimeField::new('timestamp')->setFormat("yyyy.MM.dd 'at' HH:mm:ss"),
            TextField::new('responForwarder')->onlyOnDetail(),

        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])

        ;
    }

}
