<?php

namespace App\Controller\Admin;

use App\Entity\DataAcrossHeader;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DataAcrossHeaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DataAcrossHeader::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('secret'),
            TextField::new('idProgramma'),
            TextField::new('uri'),
            TextField::new('url'),
            AssociationField::new('campaignId')
        ];
    }
    
}
