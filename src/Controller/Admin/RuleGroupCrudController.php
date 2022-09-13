<?php

namespace App\Controller\Admin;

use App\Entity\RuleGroup;
use App\Repository\RuleGroupRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            ChoiceField::new('field')->setChoices([
                'email' => 'email',
                'firstname' => 'firsname',
                'lastname' => 'lastname',
                'sex' => 'sex',
                'ip' => 'ip',
                'zip' => 'zip',
                'job' => 'job',
                'dob' => 'dob',
                'city' => 'city',
                'url' => 'url',
                'family'=>'family',
                'region'=>'region',
                'address_1' => 'address_1',
                'address_2' => 'address_2',
            ]),
            ChoiceField::new('operator')->setChoices([
                'Equal(==)' => '==',
                'Greater than(>, strlenght for txt)' => '>',
                'Lesser than (<, strlenght for txt)' => '<',
                'Contains(only str)' => 'contains',
                'Different(!=)' => '!=',
                'Not empty' => 'notempty',
                'True' => 'true',
                'False' => 'false',
                'city' => 'city',
            ]),
            TextField::new('value'),
            DateTimeField::new('valueDate'),
            TextareaField::new('description'),
        ];
    }

}
