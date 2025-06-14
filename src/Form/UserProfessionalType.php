<?php

namespace App\Form;

use App\Entity\Etablissement;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserProfessionalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
                    new IsTrue([                                                           
                        'message' => 'You should agree to our terms.',  
                    ]),                                                                                    
                ],                                                                                        
            ])                                                                                                  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
