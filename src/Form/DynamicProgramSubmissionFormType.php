<?php

namespace App\Form;

use App\Entity\ProgramSubmission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DynamicProgramSubmissionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $programSubmission = $options['data'];

        $builder
            ->add('nationality', ChoiceType::class, [
                'label' => 'Nationality',
                'choices' => ['French' => 'French', 'English' => 'English'], // Modify choices as needed
                'required' => $programSubmission->isNationalityNeeded(),
            ])
            ->add('passportNumber', null, [
                'label' => 'Passport Number',
                'required' => $programSubmission->isPassportNeeded(),
            ])
            ->add('cv', null, [
                'label' => 'CV',
                'required' => $programSubmission->isCvNeeded(),
            ])
            // Add other fields as needed based on ProgramSubmission properties
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProgramSubmission::class,
        ]);
    }
}
