<?php

namespace App\Controller\Admin;

use App\Entity\RuleGroup;
use App\Repository\RuleGroupRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RuleGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RuleGroup::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        
        return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL);
        
        
    }
/*
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            // TextField::new('name'),
            // TextEditorField::new('description'),
        ];
    }
*/
}
