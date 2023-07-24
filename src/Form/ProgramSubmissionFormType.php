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
        ->add('passport', ChoiceType::class, [
            'choices' => [
                'Not Needed' => 'not_needed',
                'Needed' => 'needed',
            ],
            'expanded' => true,
        ])
        ->add('cv', ChoiceType::class, [
            'choices' => [
                'Not Needed' => 'not_needed',
                'Needed' => 'needed',
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
