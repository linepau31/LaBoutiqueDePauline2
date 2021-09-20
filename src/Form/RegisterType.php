<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => new Length([
                    'min' => 2,
                    'max'=> 30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de renseigner votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'constraints' => new Length([
                    'min' => 2,
                    'max'=> 30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de renseigner votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => new Length([
                    'min' => 2,
                    'max'=> 60
                ]),
                 'attr' => [
                'placeholder' => 'Merci de renseigner votre adresse email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe est la confirmation doivent être identique!',
                'label' => 'Mot De Passe',
                'required' => true,
                'first_options' => [ 'label' => 'Mot De Passe',
                        'attr' => [
                            'placeholder' => 'Merci de renseigner votre Mot de passe'
                        ]
                    ],
                'second_options' => [ 'label' => 'Confirmer votre Mot De Passe',
                        'attr' => [
                            'placeholder' => 'Merci de confirmer votre Mot de passe'
                        ]
                    ],

            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
