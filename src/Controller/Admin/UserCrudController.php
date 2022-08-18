<?php

namespace App\Controller\Admin;

use App\Entity\Supplier;
use App\Entity\User;
use App\Form\SupplierType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
        
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
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('company'),
            TextField::new('country'),
            TextField::new('zipCode'),
            AssociationField::new('fkSupplier')
            ->autocomplete(),
            TextField::new('region'),
            TextField::new('registrationNumber'),
            TextField::new('city'),
            BooleanField::new('isVerified'),
           
           
            
        ];
    }
    
}
