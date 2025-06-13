<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserPersonalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder                                    
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank(message: 'Le Prénom est obligatoire')
                ]
            ])
            ->add('civilite', ChoiceType::class, [                                                   
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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
