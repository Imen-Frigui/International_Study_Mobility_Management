<?php

namespace App\Form;

use App\Entity\ProgramSubmission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class DynamicProgramSubmissionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $programSubmission = $options['data'];

        $builder

            ->add('passportNumber', null, [
                'label' => 'Passport Number',
                'mapped' => false,
                'required' => $programSubmission->isPassportNeeded(),
            ])
            ->add('cv', null, [
                'label' => 'CV',
                'mapped' => false,
                'required' => $programSubmission->isCvNeeded(),
            ])
            ->add('recommendationLetter', null, [
                'label' => 'recommendationLetter',
                'mapped' => false,
                'required' => $programSubmission->isRecommendationLetterNeeded(),
            ])
            ->add('englishLanguageCertificate', null, [
                'label' => 'englishLanguageCertificateNeeded',
                'mapped' => false,
                'required' => $programSubmission->isEnglishLanguageCertificateNeeded(),
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
            'programSubmission' => null, // Add the programSubmission option with a default value of null
        ]);
    }
}
