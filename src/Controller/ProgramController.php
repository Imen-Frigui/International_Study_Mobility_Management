<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Entity\Document;
use App\Form\ProgramSubmissionFormType;
use App\Form\DocumentType;
use App\Repository\ProgramSubmissionRepository;
use App\Form\DynamicProgramSubmissionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ProgramSubmission;
use App\Entity\StudentSubmission;
use App\Entity\Student;
use App\Repository\NotificationRepository;


class ProgramController extends AbstractController
{
    #[Route('/', name: 'app_program')]
    public function index(ProgramRepository $programRepository, NotificationRepository $notificationRepository): Response
    {
        $programs = $programRepository->findAll();
        // In another controller
         $student = $this->get('session')->get('student');

        // Check if the student is in the session
        if (!$student) {
            // Handle the case where the student is not found in the session, maybe redirect to the login page
            return $this->redirectToRoute('student_login');
        }

       // $student = $this->getDoctrine()->getRepository(Student::class)->find(1);
        $notifications = $notificationRepository->findBy(['student' => $student, 'hasRead' => false]);

        return $this->render('program/index.html.twig', [
            'programs' => $programs,
            'notifications' => $notifications,
            'student' => $student,
        ]);
    }

    #[Route('/programs', name: 'program_list')]
    public function listPrograms(ProgramRepository $programRepository): Response
    {
        // Fetch the list of programs from the repository
        $programs = $programRepository->findAll();

        // Render a template and pass the list of programs to it
        return $this->render('program/list.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/program/{id}', name:'app_program_details')]
    public function programDetails(ProgramRepository $programRepository, int $id, NotificationRepository $notificationRepository):Response
    {
        $program = $programRepository->find($id);

        $student = $this->get('session')->get('student');

        // Check if the student is in the session
        if (!$student) {
            // Handle the case where the student is not found in the session, maybe redirect to the login page
            return $this->redirectToRoute('student_login');
        }
        $notifications = $notificationRepository->findBy(['student' => $student, 'hasRead' => false]);

        return $this ->render ('program/program_details.html.twig',[
            'program' => $program,
            'notifications' => $notifications,
            'student' => $student,

        ]);
    }


    #[Route('/program/{id}/submission', name: 'app_program_submission')]
    public function submissionForm(ProgramRepository $programRepository, int $id, Request $request): Response
    {
        $program = $programRepository->find($id);
        
        $form = $this->createForm(ProgramSubmissionFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the submitted form data and save it to the database
            $formData = $form->getData();

            // Assuming you have a ProgramSubmission entity to save the form data
            $submission = new ProgramSubmission();
            $submission->setProgram($program);
 
            // Set other form fields as needed
            $submission->isPassportNeeded($formData['passportNumber']);
            $submission->isNationalityNeeded($formData['Nationality']);
            $submission->isRecommendationLetterNeeded($formData['RecommendationLetter']);
            $submission->isCvNeeded($formData['CV']);
            $submission->isEnglishLanguageCertificateNeeded($formData['English_Certificat']);
            $submission->isOtherDocumentsNeeded($formData['Other_Documents']);
            // Save the submission to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($submission);
            $entityManager->flush();

            // Redirect to a success page or show a success message
            // Example:
            $this->addFlash('success', 'Submission saved successfully!');
            return $this->redirectToRoute('app_program');
        }

        return $this->render('program/submission_form.html.twig', [
            'program' => $program,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/program/{id}/add-document', name: 'add_document_to_program')]
    public function addDocumentToProgram(Program $program, Request $request, ProgramRepository $programRepository, int $id): Response
    {
         $program = $programRepository->find($id);

        // Create a form to handle document upload
        $document = new Document(); // Create a new Document entity

        $document->setProgram($program);

        $form = $this->createForm(DocumentType::class, $document); // Use the form to handle this document entity

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload (if applicable) and associate the document with the program

            // Save the document to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($document); // Persist the document entity
            $entityManager->flush();

            // Redirect to a success page or show a success message
            // Example:
            $this->addFlash('success', 'Document added to the program successfully!');
            return $this->redirectToRoute('program_list', ['id' => $program->getId()]);
        }

        return $this->render('program/add_document.html.twig', [
            'program' => $program,
            'form' => $form->createView(),
        ]);
    }

}
