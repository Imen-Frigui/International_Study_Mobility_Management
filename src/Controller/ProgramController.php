<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Form\ProgramSubmissionFormType;
use App\Repository\ProgramSubmissionRepository;
use App\Form\DynamicProgramSubmissionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ProgramSubmission;
use App\Entity\StudentSubmission;

class ProgramController extends AbstractController
{
    #[Route('/', name: 'app_program')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/index.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/program/{id}', name:'app_program_details')]
    public function programDetails(ProgramRepository $programRepository, int $id):Response
    {
        $program = $programRepository->find($id);

        return $this ->render ('program/program_details.html.twig',[
            'program' => $program,
        ]);
    }

    #[Route('/submit/{id}', name: 'app_program_submit')]
    public function submitProgram(ProgramRepository $programRepository, int $id, ProgramSubmissionRepository $programSubmissionRepository, Program $program, Request $request): Response
    {
        $program = $programRepository->find($id);
        // Fetch the program submissions related to the given program
        $programSubmissions = $programSubmissionRepository->findBy(['program' => $program]);

        // Create a form for each program submission
        $forms = [];
        foreach ($programSubmissions as $programSubmission) {
            $form = $this->createForm(DynamicProgramSubmissionFormType::class, $programSubmission);
            $form->handleRequest($request);
            $forms[] = $form->createView();

            if ($form->isSubmitted() && $form->isValid()) {
                // Save the form data to the database (you may need to modify this part)
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($programSubmission);
                $entityManager->flush();
            }
        }

        return $this->render('program/submit_program.html.twig', [
            'program' => $program,
            'forms' => $forms,
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

}
