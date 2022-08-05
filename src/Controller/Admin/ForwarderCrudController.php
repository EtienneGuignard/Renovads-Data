<?php

namespace App\Controller\Admin;

use App\Entity\Forwarder;
use App\Entity\Leads;
use App\Form\LeadsType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\CodeEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ForwarderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Forwarder::class;


    }

    public function configureActions(Actions $actions): Actions
    
    {
        $detailAdd= Action::new('addBody','Add Body Forwarder')
        ->linkToRoute('app_forwarder', function (Forwarder $forwarder): array {
            return [
                'forwarderId' => $forwarder->getId(),
            ];
        });;
        return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_DETAIL, $detailAdd);
        
    }
    
    public function configureFields(string $pageName): iterable
    {
    
        return [
            TextField::new('name'),
            TextField::new('url')
        ];
    }
    
}
