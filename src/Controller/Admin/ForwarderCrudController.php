<?php

namespace App\Controller\Admin;

use App\Entity\Forwarder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ForwarderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Forwarder::class;


    }
    
    public function configureAssets(Assets $assets): Assets
    {
        return $assets

        ->addCssFile('build/admin.css');
    }

    public function configureActions(Actions $actions): Actions
    
    {
        $detailAdd= Action::new('addBody','Add Body Forwarder')
        ->linkToRoute('app_forwarder', function (Forwarder $forwarder): array {
            return [
                'forwarderId' => $forwarder->getId(),
            ]; });

         $test= Action::new('testForwarder','Test Forwarder')
            ->linkToRoute('app_forwarder_test', function (Forwarder $forwarder): array {
                return [
                    'forwarderId' => $forwarder->getId(),
                ]; });

       
        return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ->add(Crud::PAGE_DETAIL, $detailAdd)
        ->add(Crud::PAGE_DETAIL, $test);
        
    }
    
    public function configureFields(string $pageName): iterable
    {
    
        return [
            TextField::new('name'),
            TextField::new('url')
        ];
    }
    
}
