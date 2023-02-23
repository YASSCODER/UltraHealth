<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Transformer\StringToFileTransformer;




class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('author')
            ->add('image', FileType::class, [
                'required' => false,
                'label' => 'Image file',
            ])
            ->get('image')->addViewTransformer(new StringToFileTransformer($options['data_class']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
    


    
    
}
