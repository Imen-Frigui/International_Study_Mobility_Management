<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Program;
use App\Entity\ProgramSubmission;
use App\Form\ProgramType;
use App\Repository\ProgramSubmissionRepository;
use App\Repository\ProgramRepository;




class AdminController extends AbstractController
{
    #[Route('/admin/program/create', name: 'app_admin')]
    public function createProgram(Request $request): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($program);
            $entityManager->flush();

            $this->addFlash('success', 'Program created successfully!');

            // Redirect to a page where you list all programs or any other appropriate route.
            return $this->redirectToRoute('program_list');
        }

        return $this->render('admin/create_program.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/review-submissions/{id}', name: 'review_submissions')]
    public function reviewSubmissions(int $id, ProgramRepository $programRepository, ProgramSubmissionRepository $programSubmissionRepository): Response
    {
        // Find the program
        $program = $programRepository->find($id);
    
        if (!$program) {
            throw $this->createNotFoundException('Program not found');
        }
    
        // Fetch the submissions for this program
        $submissions = $programSubmissionRepository->findBy(['program' => $program]);
    
        // Sort the submissions based on the average grade of the associated student
        usort($submissions, function ($a, $b) {
            $averageGradeA = $a->getStudent()->getAverageGrade();
            $averageGradeB = $b->getStudent()->getAverageGrade();
            return $averageGradeB <=> $averageGradeA; // Descending order
        });
    
        // Render a template to display the submissions
        return $this->render('program/review_submissions.html.twig', [
            'program' => $program,
            'submissions' => $submissions,
        ]);
    }    

    #[Route('/accept_submission/{id}', name: 'accept_submission')]
    public function acceptSubmission(int $id, ProgramSubmission $programSubmission, ProgramSubmissionRepository $programSubmissionRepository): Response
    {
        $programSubmission = $programSubmissionRepository->find($id);
        $programSubmission->setStatus(ProgramSubmission::STATUS_ACCEPTED);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'Submission accepted successfully.');

        return $this->redirectToRoute('review_submissions', ['id' => $programSubmission->getProgram()->getId()]);
    }

    #[Route('/reject_submission/{id}', name: 'reject_submission')]
    public function rejectSubmission(int $id, ProgramSubmission $programSubmission, ProgramSubmissionRepository $programSubmissionRepository): Response
    {
        $programSubmission = $programSubmissionRepository->find($id);
        $programSubmission->setStatus(ProgramSubmission::STATUS_BANNED);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('danger', 'Submission rejected.');

        return $this->redirectToRoute('review_submissions', ['id' => $programSubmission->getProgram()->getId()]);
    }
}
