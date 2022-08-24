<?php

namespace App\Controller\Admin;

use App\Entity\Leads;
use DateTimeImmutable;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LeadsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Leads::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email'),
            AssociationField::new('supplier'),
            TextField::new('ip')->onlyOnDetail()->onlyOnForms(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            DateField::new('dob'),
            TextField::new('address_1'),
            TextField::new('address_2')->onlyOnDetail()->onlyOnForms(),
            TextField::new('city')->onlyOnDetail()->onlyOnForms(),
            TextField::new('region')->onlyOnDetail()->onlyOnForms(),
            TextField::new('zip'),
            TextField::new('job')->onlyOnDetail()->onlyOnForms(),
            TextField::new('children')->onlyOnDetail()->onlyOnForms(),
            TextField::new('privacy_policy')->onlyOnDetail(),
            TextField::new('confirm_privacy')->onlyOnDetail(),
            TextField::new('confirm_partners'),
            TextField::new('url'),
            DateTimeField::new('created_at'),
            DateTimeField::new('last_updated')->onlyOnDetail(),
            
        ];
    }
    
}
