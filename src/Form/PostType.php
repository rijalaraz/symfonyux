<?php

namespace App\Form;

use App\Entity\Meal;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;
use Symfonycasts\DynamicForms\DependentField;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);

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
        ;

        $builder->add('meal', EntityType::class, [
            'class' => Meal::class,
            'choice_label' => fn (Meal $meal): string => $meal->getReadable(),
            'placeholder' => 'Which meal is it?',
            'autocomplete' => true,
        ])
        // see: https://github.com/SymfonyCasts/dynamic-forms
        ->addDependent('foods', 'meal', function (DependentField $field, ?Meal $meal) {
            $field->add(FoodAutocompleteField::class,  [
                'label' => 'Aliments',
                'placeholder' => null === $meal ? 'Select a meal first' : \sprintf('What\'s for %s?', $meal->getReadable()),
                'extra_options' => [
                    'included_meals' => $meal ? [$meal->getId()] : [],
                ],
                'disabled' => null === $meal,
            ]);
        });
 
        $builder->add('photos', LiveCollectionType::class, [
                'entry_type' => PhotoType::class,
                'label' => 'Photos',
                'mapped' => false,
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
