<?php

namespace App\Controller;

use App\Service\FileUploader;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Document;
use App\Entity\Student;
use App\Entity\ProgramSubmission;
use App\Entity\ProgramFile;
use App\Form\ProgramSubmissionFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProgramRepository;
use App\Repository\StudentRepository;
use App\Repository\NotificationRepository;


class ProgramSubmissionController extends AbstractController
{
    private $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    #[Route('/submit/{id}', name: 'program_submission')]
    public function submissionForm(int $id, ProgramRepository $programRepository, Request $request, StudentRepository $studentRepository, NotificationRepository $notificationRepository): Response
    {
        // Find the program
        $program = $programRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $documents = $this->getDoctrine()->getRepository(Document::class)->findAll();
       // $student = $this->getDoctrine()->getRepository(Student::class)->find(1);
        $student = $this->get('session')->get('student');

        // Check if the student is in the session
        if (!$student) {
            // Handle the case where the student is not found in the session, maybe redirect to the login page
            return $this->redirectToRoute('student_login');
        }

        // Explicitly persist the Program and Student entities
        
        if (!$studentRepository->find($student)) {
            // If not, persist it
            $entityManager->persist($student);
        }else{
            $student = $studentRepository->find($student);
        }
        $entityManager->flush();


        $notifications = $notificationRepository->findBy(['student' => $student, 'hasRead' => false]);
        
        $programSubmission = new ProgramSubmission();

        $programSubmission->setProgram($program);
        $programSubmission->setStudent($student);

        $form = $this->createForm(ProgramSubmissionFormType::class, null, [
            'programId' => $program->getId(),
        ]);

        // Handle the form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            

            foreach ($documents as $document) {
                // Get the file input for this document
                $fileInput = $form->get('document_' . $document->getId());

                // Check if a file was uploaded for this document
                $uploadedFile = $fileInput->getData();
                if ($uploadedFile) {
                    // Generate a unique name for the file
                    $fileName = md5(uniqid()) . '.' . $uploadedFile->guessExtension();

                    // Move the file to the desired directory
                    $this->fileUploader->upload($uploadedFile, $fileName);

                    // Create a ProgramFile entity
                    $programFile = new ProgramFile();
                    $programFile->setName($uploadedFile->getClientOriginalName());
                    $programFile->setPath($fileName);
                    $programFile->setProgramSubmission($programSubmission);

                    $entityManager->persist($programFile);
                    // Associate the file with the submission
                    $programSubmission->addProgramFile($programFile);
               }
            }

            // Persist the submission and associated files
            $entityManager->persist($programSubmission);
            $entityManager->flush();

            // Redirect to a success page or show a success message
            // Example:
            $this->addFlash('success', 'Submission saved successfully!');
            return $this->redirectToRoute('app_program');
        }

        return $this->render('program_submission/submit.html.twig', [
            'form' => $form->createView(),
            'student' => $student,
            'notifications' => $notifications
        ]);
    }
}
