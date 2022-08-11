<?php

namespace App\Form;

use App\Entity\Campaign;
use App\Entity\Supplier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campaign', EntityType::class,[
                'class' =>Campaign::class ,
                'choice_label' => 'name',
                'placeholder' => 'Campaign',
            ])
            ->add('supplier', EntityType::class,[
                'class' =>Supplier::class ,
                'choice_label' => 'reference',
                'placeholder' => 'Supplier',
            ])
            ->add('status', ChoiceType::class,[
                'choices'=> [
                    'All'=>'all',
                    'Accepted'=>'accepted',
                    'Rejected'=>'rejected'
                    ]
            ])
            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label'  => 'Start Date',
                'required'=> true,
            ])

            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label'  => 'End Date',
                'required'=> true,
            ])
            
            ->add('search', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
