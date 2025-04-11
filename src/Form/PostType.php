<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', options:[
                'label' => 'Titre',
                'attr' => [
                    'class' => 'form-control'
                ],
                'empty_data' => ''
            ])
            ->add('slug', options:[
                'attr' => [
                    'class' => 'form-control'
                ],
                'empty_data' => ''
            ])
            ->add('content', TextareaType::class, [
                // this field is re-rendered as you type
                // by default, the "trim" functionality will remove
                // any trailing spaces as the user types... which
                // is no bueno
                'trim' => false,
                'label' => 'Contenu',
                'attr' => [
                    'class' => 'form-control'
                ],
                'empty_data' => ''
            ])
            // ->add('createdAt', null, [
            //     'widget' => 'single_text'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
