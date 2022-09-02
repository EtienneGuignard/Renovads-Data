<?php

namespace App\Controller\Admin;

use App\Entity\ApiToken;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ApiTokenCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ApiToken::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->onlyOnDetail()
            ->onlyOnIndex(),
            TextField::new('token'),
            AssociationField::new('user')
        ];
    }
    
}
