<?php

namespace App\Form;

use App\Entity\Evennement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\Expression;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class Evennement1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('dateDebut', DateTimeType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new Expression([
                        'expression' => 'value <= this.getParent().get("dateFin").getData()',
                        'message' => 'The start date must be before or equal to the end date.',
                    ]),
                ],
            ])
            ->add('dateFin', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('zone')
            ->add('eventimg', FileType::class, [
                'label' => 'image (PNG file) ',
                'mapped' => true,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '51200k',
                        'mimeTypes' => [
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PNG file'
                    ])
                ],
            ])
            ->add('nbrPasse')
            ->add('prix', NumberType::class, [
                'label' => 'price',
                'required' => true,
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                ]
            ],)
            ->add('category');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evennement::class,
        ]);
    }
}