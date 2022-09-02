<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'label' => false,
            'attr'=>['class' => 'form-control mb-2']]
            )
        ->add('firstName', TextType::class, [
            'label' => false,
            'attr' => ['class' => 'form-control']
        ])
        ->add('lastName', TextType::class, [
            'label' => false,
            'attr' => ['class' => 'form-control']
        ] )
        ->add('plainPassword', RepeatedType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'type'=>ShowHidePasswordType::class,
            'invalid_message' => 'The passwords are not identical.',
            'mapped' => false,
            'label' => false,
            'attr' => ['autocomplete' => 'new-password'],
            'options' =>        ['attr' => ['class' => 'form-control password-field']],
            'first_options'  => ['label' => 'Password'],
            'second_options' => ['label' => 'Repeat Password'],

            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a password',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ])
        ->add('company', TextType::class, [
            'label' => false,
            'attr' => ['class' => 'form-control']
        ] )
        ->add('companyAddress', TextType::class, [
            'label' => false,
            'attr' => ['class' => 'form-control']
        ])
        ->add('country', CountryType::class, [
            'label' => false,
            'attr' => ['class' => 'form-control']
        ])
        ->add('zipCode', TextType::class, [
            'label' => false,
            'attr' => ['class' => 'form-control']
        ])
        ->add('vatNumber', TextType::class, [
            'required'=> false,
            'label' => false,
            'attr' => ['class' => 'form-control']
        ])
        ->add('region', TextType::class, [
            'required'=> false,
            'label' => false,
            'attr' => ['class' => 'form-control']
        ])
        ->add('RegistrationNumber', TextType::class, [
            'required'=> false,
            'label' => false,
            'attr' => ['class' => 'form-control']
        ])
        ->add('city', TextType::class, [
            'required'=> false,
            'label' => false,
            'attr' => ['class' => 'form-control']
        ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
