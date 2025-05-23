<?php

namespace App\Form;

use Asmitta\FormFlowBundle\Form\FormFlow;
use Asmitta\FormFlowBundle\Form\FormFlowInterface;

class UserFlowForm extends FormFlow
{
    protected function loadStepsConfig(): array
    {
        return [
            [
                'label' => 'Information',
                'form_type' => RegistrationForm1::class,
            ],
            [
                'label' => 'Contact',
                'form_type' => RegistrationForm2::class,
                'skip' => function($estimatedCurrentStepNumber, FormFlowInterface $flow) {
					return $estimatedCurrentStepNumber > 1;
				},
            ],
            [
                'label' => 'Etablissement',
                'form_type' => RegistrationForm3::class,
            ],
        ];
    }
}
