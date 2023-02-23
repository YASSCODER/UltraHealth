<?php

namespace App\Form;

use App\Entity\RendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\GreaterThan;



class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           // ->add('dateRdv')
          ->add('dateRdv', DateTimeType::class, [
            'label' => 'Appointment Date and Time',
            'widget' => 'single_text',
            'input' => 'datetime_immutable', // This will ensure that the form field value is bound to a DateTimeImmutable object
        ])


        /*->add('dateRdv', DateTimeType::class, [
           'constraints' => [
          new GreaterThan('today')
    ]
])
*/
            ->add('heure')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
