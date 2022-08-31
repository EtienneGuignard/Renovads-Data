<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'attr'=>['class' => 'form-control mb-2']]
                )
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label'=> 'To register you have to agree to the terms and condition of renovads data',
                'attr'=>['class' => 'mt-4'],
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
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
            ->add('firstName', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control']
            ] )
            ->add('company', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control']
            ] )
            ->add('companyAddress', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('country', Country::class, [
                'label' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('zipCode', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('vatNumber', TextType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control']
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => ['class' => 'form-control']
        ]);
    }
}
