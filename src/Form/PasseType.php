<?php

namespace App\Form;

use App\Entity\Passe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('prix', NumberType::class, [
                'label' => 'price',
                'required' => true,
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                ]
            ],)
            ->add('evennement')
            ->add('PasseOwner');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Passe::class,
        ]);
    }
}
