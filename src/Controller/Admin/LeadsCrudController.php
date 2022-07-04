<?php

namespace App\Controller\Admin;

use App\Entity\Leads;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LeadsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Leads::class;
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
