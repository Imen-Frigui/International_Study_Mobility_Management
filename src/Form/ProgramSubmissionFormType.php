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
use Symfony\Component\Form\Extension\Core\Type\FileType;


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

        // Retrieve the documents associated with the program
        $documents = $this->documentRepository->findByProgram($programId);


        foreach ($documents as $document) {
            $fieldName = 'document_' . $document->getId();
            // Add a file upload field for each document
            $builder->add($fieldName, FileType::class, [
                'label' => $document->getName(), // Use the document name as the label
                'required' => true,
                'mapped' => false,
            ]);
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProgramSubmission::class, // Set the correct entity class
            'programId' => null,
        ]);
    }

}

