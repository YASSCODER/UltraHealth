<?php

namespace App\Form;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Expression;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Transformer\StringToFileTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;




class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', TextType::class, [
            'label' => 'article.title',
            'translation_domain' => 'messages',
        ])
    
       
        ->add('description', TextareaType::class, [
            'label' => 'article.content',
            'translation_domain' => 'messages',
        ])
        
            ->add('author')
            ->add('image', FileType::class, [
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
    


    
    
}
