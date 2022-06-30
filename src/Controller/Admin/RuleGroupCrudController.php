<?php

namespace App\Controller\Admin;

use App\Entity\RuleGroup;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RuleGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RuleGroup::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('name'),
            // TextEditorField::new('description'),
        ];
    }

}
