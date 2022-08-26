<?php

namespace App\Form;

use App\Entity\BodyForwarder;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BodyForwarderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [

                'attr' => ['class' => 'form-control'],
                'placeholder' => 'choose Type',
                'choices' => [
                    
                    'Static' => 'static',
                    'Header' => 'header',
                    'Field' => 'field',
                    'Lastname' => 'lastname',
                    'Sex' => 'sex',
                    'Adresse' => 'address_1',
                    'Zip' => 'zip',
                    'Job' => 'job',
                    'Created at' => 'created_at',
                    'Family' => 'family',
                ]
            ])
            // ->add('input', ChoiceType::class, [

            //     'attr' => ['class' => 'form-control'],
            //     'placeholder' => 'choose input',
            //     'choices' => [
                    
            //         'Email' => 'email',
            //         'Date of birth' => 'dob',
            //         'Firstname' => 'firstname',
            //         'Lastname' => 'lastname',
            //         'Sex' => 'sex',
            //         'Adresse' => 'address_1',
            //         'Zip' => 'zip',
            //         'Job' => 'job',
            //         'Created at' => 'created_at',
            //         'Family' => 'family',
            //     ]
            // ] )
            ->add('input', TextType::class, [

                'attr' => ['class' => 'form-control'],
            ])
            ->add('outpout', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('Add', SubmitType::class,  [
                'attr' => ['class' => 'btn btn-primary mt-2'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BodyForwarder::class,
        ]);
    }
}
