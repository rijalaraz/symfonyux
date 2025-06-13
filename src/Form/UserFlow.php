<?php

namespace App\Form;

use Asmitta\FormFlowBundle\Form\FormFlow;

final class UserFlow extends FormFlow
{
    protected function loadStepsConfig(): array
    {
        return [
            [
                'label' => 'Name',
                'form_type' => RegistrationForm::class,
            ],
            [
                'label' => 'Contact',
                'form_type' => RegistrationForm::class,
            ],
            [
                'label' => 'Profession',
                'form_type' => RegistrationForm::class,
            ],
        ];
    }
}
