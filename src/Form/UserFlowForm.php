<?php

namespace App\Form;

use Craue\FormFlowBundle\Form\FormFlow;


class UserFlowForm extends FormFlow
{
    protected function loadStepsConfig(): array
    {
        return [
            [
                'label' => 'Information',
                'form_type' => RegistrationForm::class,
            ],
            [
                'label' => 'Contact',
                'form_type' => RegistrationForm::class,
            ],
            [
                'label' => 'Etablissement',
                'form_type' => RegistrationForm::class,
            ],
        ];
    }
}
