<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', options:[
                'label' => 'Titre',
                'empty_data' => ''
            ])
            ->add('slug', options:[
                'empty_data' => ''
            ])
            ->add('content', TextareaType::class, [
                // this field is re-rendered as you type
                // by default, the "trim" functionality will remove
                // any trailing spaces as the user types... which
                // is no bueno
                'trim' => false,
                'label' => 'Contenu',
                'empty_data' => ''
            ])
            ->add('situation', SituationAutocompleteField::class, [
                'label' => 'Situation',
            ])
            ->add('foods', FoodAutocompleteField::class, [
                'label' => 'Aliments',
                'attr' => [
                    'placeholder' => 'Choisis ce que tu aimerais manger'
                ],
            ])
            ->add('photos', LiveCollectionType::class, [
                'entry_type' => PhotoType::class,
                'label' => 'Photos',
                // 'mapped' => false,
            ])
            ->add('comments', LiveCollectionType::class, [
                'entry_type' => CommentType::class,
                'label' => 'Commentaires',
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
