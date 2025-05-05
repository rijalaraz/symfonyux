<?php

namespace App\Form;

use App\Entity\Situation;
use App\Repository\SituationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
class SituationAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Situation::class,
            'placeholder' => 'Choisis une situation',
            'choice_label' => 'name',

            // choose which fields to use in the search
            // if not passed, *all* fields are used
            'searchable_fields' => ['name'],

            // 'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
