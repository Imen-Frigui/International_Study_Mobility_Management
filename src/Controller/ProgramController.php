<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Form\ProgramSubmissionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ProgramSubmission;

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

   // ProgramController.php

// ...

#[Route('/program/{id}/submit', name: 'app_program_submit')]
public function submitProgram(Program $program, Request $request): Response
{
    // Fetch the ProgramSubmission for the given Program
    $programSubmission = $program->getProgramSubmission();

    // Create a new FormBuilder
    $formBuilder = $this->createFormBuilder();

    // Add form fields based on the ProgramSubmission properties
    if ($programSubmission->isCvNeeded()) {
        $formBuilder->add('cv', FileType::class, [
            'label' => 'CV Upload',
            // Add any other options you need for this field
        ]);
    }

    // Add other fields based on other properties of ProgramSubmission

    $form = $formBuilder->getForm();
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Get the submitted form data and process it as needed
        $formData = $form->getData();
        // ... Process the form data ...
    }

    return $this->render('program/submit_form.html.twig', [
        'program' => $program,
        'form' => $form->createView(),
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
