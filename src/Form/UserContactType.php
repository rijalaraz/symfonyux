<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder                                                                                          
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(message: "L'Email est obligatoire"),
                    new Email(message: "The email '{{ value }}' is not valid.", mode:"strict")
                ]
            ])                                                                                                                       
            ->add('plainPassword', PasswordType::class, [                                                                               
                // instead of being set onto the object directly, this is read and encoded in the controller                                                                           
                'mapped' => false,                                                                                                      
                'attr' => ['autocomplete' => 'new-password'],                                                                           
                'constraints' => [                                                                                                      
                    new NotBlank([                                                                                                      
                        'message' => 'Please enter a password',                                                                         
                    ]),                                                                                                                 
                    new Length([                                                                                                        
                        'min' => 6,                                                                                                     
                        'minMessage' => 'Your password should be at least {{ limit }} characters',                                      
                        // max length allowed by Symfony for security reasons                                                           
                        'max' => 4096,                                                                                                  
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
