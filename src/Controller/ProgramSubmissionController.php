<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ProgramSubmission;
use App\Form\ProgramSubmissionFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProgramRepository;


class ProgramSubmissionController extends AbstractController
{
    #[Route('/submit/{id}', name: 'program_submission')]
    public function submissionForm(int $id, ProgramRepository $programRepository, Request $request): Response
    {
        // Create a new ProgramSubmission entity
        $programSubmission = new ProgramSubmission();
  
        $program = $programRepository->find($id);

        $form = $this->createForm(ProgramSubmissionFormType::class, null, [
            'programId' => $program->getId(),
        ]);

       // Handle the form submission
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle the submission and save it to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($programSubmission);
            $entityManager->flush();

            // Redirect to a success page or show a success message
            // Example:
            $this->addFlash('success', 'Submission saved successfully!');
            return $this->redirectToRoute('app_program');
        }

        return $this->render('program_submission/submit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
