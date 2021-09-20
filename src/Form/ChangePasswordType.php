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

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' =>true,
                'label' => 'Mon Email'
            ])
            ->add('firstname', TextType::class, [
                'disabled' =>true,
                'label' => 'Mon Prénom'
            ])
            ->add('lastname', TextType::class, [
                'disabled' =>true,
                'label' => 'Mon Nom'
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Mon mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Merci de renseigner votre mot de passe actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Le mot de passe est la confirmation doivent être identique!',
                'label' => 'Mon nouveau Mot de passe',
                'required' => true,
                'first_options' => [ 'label' => 'Mon nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de renseigner votre nouveau mot de passe actuel'
                    ]
                ],
                'second_options' => [ 'label' => 'Confirmer votre nouveau mot De Passe',
                    'attr' => [
                        'placeholder' => 'Merci de confirmer votre nouveau mot de passe'
                    ]
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Valider",
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
