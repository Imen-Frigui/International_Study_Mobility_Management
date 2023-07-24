<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Form\ProgramSubmissionFormType;
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
    public function submitProgram(ProgramRepository $programRepository, ProgramSubmission $programSubmission, int $id, Request $request)
    {
        $program = $programRepository->find($id);
        $programSubmission = $program->getProgramSubmission(); // Assuming you have a method to get the associated ProgramSubmission for a Program
        
        if (!$programSubmission) {
            // If there is no ProgramSubmission associated with the Program, return an error or handle it as needed
            // For example, you could redirect back to the program listing page with a flash message.
            return $this->redirectToRoute('app_program');
        }

        // Create a new instance of the StudentSubmission entity
        $studentSubmission = new StudentSubmission();
        $studentSubmission->setProgram($program);

        // Create the form using the DynamicProgramSubmissionFormType and pass the ProgramSubmission data
        $form = $this->createForm(DynamicProgramSubmissionFormType::class, $programSubmission);

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($studentSubmission);
            $entityManager->flush();

            // Redirect to a success page or show a success message
            // Example:
            $this->addFlash('success', 'Your submission has been saved successfully!');
            return $this->redirectToRoute('app_program');
        }

        return $this->render('program/submit_form.html.twig', [
            'form' => $form->createView(), 'program' => $program,
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
            $submission->setCv($formData['cv']);
            // Set other form fields as needed

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
