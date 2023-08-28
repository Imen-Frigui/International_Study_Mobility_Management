<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Program;
use App\Entity\Document;
use App\Entity\ProgramSubmission;
use App\Repository\DocumentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProgramSubmissionFormType extends AbstractType
{
    private DocumentRepository $documentRepository;

    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $programId = $options['programId'];

        $builder
            ->add('documents', EntityType::class, [
                'class' => Document::class,
                'choices' => $this->documentRepository->findByProgram($programId),
                'choice_label' => 'name',
                'multiple' => true,
            ]);
        // Add other form fields as needed
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProgramSubmission::class, // Set the correct entity class
            'programId' => null, // Default value for programId
        ]);
    }

}

