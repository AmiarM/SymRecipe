<?php

namespace App\Form;

use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Nom',
                'label_attr'=>[
                    'class'=>'col-sm-2 col-form-label',
                    'minLength'=>2,
                    'maxLength'=>50
                ],
                'attr'=>[
                    'placeholder'=>'Nom de l\'ingrédient',
                    'class'=>'form-control'
                ],
                'constraints'=>[
                    new Assert\Length(['min'=>2,'max'=>'50']),
                    new Assert\NotBlank()
                ]
            ])
            ->add('price',MoneyType::class,[
                'label'=>'Prix',
                'label_attr'=>[
                    'class'=>'col-sm-2 col-form-label'
                ],
                'attr'=>[
                    'placeholder'=>'Prix de l\'ingrédient',
                    'class'=>'form-control'
                ],
                'constraints'=>[
                    new Assert\Positive(),
                    new Assert\LessThan(200)
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'créer un ingrédient',
                'attr'=>[
                    'class'=>'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}