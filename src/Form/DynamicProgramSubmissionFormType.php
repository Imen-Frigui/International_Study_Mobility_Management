<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Program; // Import the Program entity
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class DynamicProgramSubmissionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Program $program */
        $program = $options['program'];

        // Loop through the program's documents and add form fields accordingly
        foreach ($program->getDocuments() as $document) {
            // Use the document's name as the field label and the document's ID as the field name
            $fieldName = 'document_' . $document->getId();

            $builder->add($fieldName, CheckboxType::class, [
                'label' => $document->getName(),
                'required' => true, // Adjust this based on your requirements
                'mapped' => false, // We don't map these fields to an entity property
            ]);
        }

        // Add other fields as needed
        $builder
            ->add('passportNumber', TextType::class, [
                'label' => 'Passport Number',
                'mapped' => false, // This field is not mapped to an entity property
                'required' => $program->isPassportNeeded(), // Determine if it's required based on the program
            ])
            // Add other program-specific fields here

            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your data class if applicable
            // 'data_class' => YourEntity::class,
        ]);

        $resolver->setRequired('program'); // Require the 'program' option to be passed
    }
}
