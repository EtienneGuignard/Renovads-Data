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
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
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
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            AssociationField::new('supplier'),
            TextField::new('ip')->hideOnIndex(),
            TextField::new('sex'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            DateField::new('dob'),
            TextField::new('phone'),
            TextField::new('address_1')->hideOnIndex(),
            TextField::new('address_2')->hideOnIndex(),
            TextField::new('city')->hideOnIndex(),
            TextField::new('region')->hideOnIndex(),
            TextField::new('zip'),
            TextField::new('job')->hideOnIndex(),
            TextField::new('children')->hideOnIndex(),
            TextField::new('privacy_policy')->onlyOnDetail(),
            BooleanField::new('confirm_privacy')->onlyOnDetail(),
            BooleanField::new('confirm_partners'),
            TextField::new('url'),
            DateTimeField::new('created_at'),
            DateTimeField::new('last_updated')->onlyOnDetail(),
            
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])

        ;
    }
    
}
