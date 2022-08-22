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
                'attr' => ['class' => 'form-control'],
                'choice_label' => 'name',
                'placeholder' => 'Campaign',
            ])
            ->add('supplier', EntityType::class,[
                'class' =>Supplier::class ,
                'attr' => ['class' => 'form-control'],
                'choice_label' => 'reference',
                'placeholder' => 'Supplier',
            ])
            ->add('status', ChoiceType::class,[
                'attr' => ['class' => 'form-control'],
                'choices'=> [
                    'All'=>'all',
                    'Accepted'=>'accepted',
                    'Rejected'=>'rejected'
                    ]
            ])
            ->add('startDate', DateTimeType::class, [
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
                'label'  => 'Start Date',
                'required'=> true,
            ])

            ->add('endDate', DateTimeType::class, [
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
                'label'  => 'End Date',
                'required'=> true,
            ])
            
            ->add('search', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
