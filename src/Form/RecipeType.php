<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Ingredient;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Nom',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Nom de la Recette'
                ],
                'constraints'=>[
                    new Assert\Length(['min'=>2,'max'=>'50']),
                    new Assert\NotBlank()
                ]
            ])
            ->add('time',IntegerType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'min'=>1,
                    'max'=>1440
                ],
                'label'=>'Temps(en minute)',
                'constraints'=>[
                    new Assert\Positive(),
                    new Assert\LessThan(1441)
                ]

            ])
            ->add('nbPeople',IntegerType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'min'=>1,
                    'max'=>50
                ],
                'label'=>'Nmbre de Personne',
                'constraints'=>[
                    new Assert\Positive(),
                    new Assert\LessThan(50)
                ]
            ])
            ->add('difficulty',RangeType::class,[
                'attr'=>[
                    'class'=>'form-range',
                    'min'=>1,
                    'max'=>5
                ],
                'label'=>'Difficulté',
                'constraints'=>[
                    new Assert\Positive(),
                    new Assert\LessThan(5)
                ]
            ])
            ->add('description',TextareaType::class,[
                'label'=>'description',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Description de la Recette'
                ],
                'constraints'=>[
                    new Assert\NotBlank()
                ]
            ])
            ->add('price',MoneyType::class,[
                'label'=>'Prix',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'Prix de la Recette'
                ],
                'constraints'=>[
                    new Assert\Positive(),
                    new Assert\LessThan(1001)
                ]
            ])
            ->add('isFavorite',CheckboxType::class,[
                'label'=>'Favoris',
                'attr'=>[
                    'class'=>''
                ]
            ]) 
            ->add('ingredients', EntityType::class, [
                'label' => 'Choisir des ingrediants:',
                'required' => true,
                'class' => Ingredient::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Enregistrer',
                'attr'=>[
                    'class'=>'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}