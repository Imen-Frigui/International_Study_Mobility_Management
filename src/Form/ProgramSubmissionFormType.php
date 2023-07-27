<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProgramSubmissionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('CV', ChoiceType::class, [
            'choices' => [
                'Not Needed' => false,
                'Needed' => true,
            ],
            'expanded' => true,
        ])
        ->add('RecommendationLetter', ChoiceType::class, [
            'choices' => [
                'Not Needed' => false,
                'Needed' => true,
            ],
            'expanded' => true,
        ])
        ->add('English_Certificat', ChoiceType::class, [
            'choices' => [
                'Not Needed' => false,
                'Needed' => true,
            ],
            'expanded' => true,
        ])
        ->add('Other_Documents', ChoiceType::class, [
            'choices' => [
                'Not Needed' => false,
                'Needed' => true,
            ],
            'expanded' => true,
        ])
        ->add('Nationality', ChoiceType::class, [
            'choices' => [
                'Not Needed' => false,
                'Needed' => true,
            ],
            'expanded' => true,
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
