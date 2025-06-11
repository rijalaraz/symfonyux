<?php

namespace App\Form;

use App\Entity\Etablissement;
use App\Entity\User;
use App\Enum\Civilite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        switch ($options['flow_step']) {
            case 1:
                $builder
                    ->add('prenom', TextType::class, [
                        'label' => 'Prénom',
                        'constraints' => [
                            new NotBlank(message: 'Le Prénom est obligatoire')
                        ]
                    ])
                    ->add('civilite', ChoiceType::class, [
                        'label' => 'Civilité',
                        'choices' => [
                            'M.' => 'monsieur',
                            'Mme.' => 'madame',
                            'Mlle.' => 'mademoiselle'
                        ],
                        'expanded' => true,
                        'constraints' => [
                            new NotBlank(message: 'La Civilité est obligatoire')
                        ]
                    ])
                ;
                break;

            case 2:
                $builder
                    ->add('email', EmailType::class, [
                        'label' => 'Email',
                        'constraints' => [
                            new NotBlank(message: "L'Email est obligatoire"),
                            new Email(message: "The email '{{ value }}' is not valid.", mode:"strict")
                        ]
                    ])
                    ->add('plainPassword', PasswordType::class, [
                        'label' => 'Mot de passe',
                        // instead of being set onto the object directly, this is read and encoded in the controller
                        'mapped' => false,
                        'always_empty' => false,
                        'attr' => ['autocomplete' => 'new-password'],
                        'constraints' => [
                            new NotBlank(
                                message: 'Please enter a password'
                            ),
                            new Length(
                                min: 6,
                                minMessage: 'Your password should be at least {{ limit }} characters',
                                // max length allowed by Symfony for security reasons
                                max: 4096
                            ),
                        ],
                    ])
                ;
                break;

            case 3:
                $builder
                    ->add('etablissement', EntityType::class, [
                        'class' => Etablissement::class,
                        'choice_label' => 'nom_etablissement',
                        'placeholder' => 'Which Etablissement is it?',
                        'autocomplete' => true,
                        'constraints' => [
                            new NotBlank(message: "L'Etablissement est obligatoire")
                        ]
                    ])
                    ->add('agreeTerms', CheckboxType::class, [
                        'mapped' => false,
                        'constraints' => [
                            new IsTrue(
                                message: 'You should agree to our terms.'
                            ),
                        ],
                    ])
                ;
                break;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'flow_step' => 1,
        ]);
    }
}
