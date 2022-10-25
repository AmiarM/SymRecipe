<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label'=>'Email',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Votre Email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'first_options'  => [
                    'label' => 'Password',
                    'attr' => [
                        'placeholder' => 'votre mot de passe',
                        'class'=>'form-control'
                    ]
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                    'attr' => [
                        'placeholder' => 'Votre Mot de Passe',
                        'class'=>'form-control'
                    ]
                ]
            ])

            ->add('fullName',TextType::class,[
                'label'=>'  FullName',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Votre FullName'
                ]
            ])
            ->add('pseudo',TextType::class,[
                'label'=>'Pseudo',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Votre Pseudo'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Register',
                'attr'=>[
                    'class'=>'btn btn-primary mt-4'
                ]
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