<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\StudentSubmission;
use App\Repository\StudentRepository;

class SubmitionController extends AbstractController
{
    #[Route('/submition', name: 'app_submition')]
    public function index(StudentSubmission $studentSubmission): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $studentSubmissionRepository = $entityManager->getRepository(StudentSubmission::class);

        // Query to get all StudentSubmission records
        $studentSubmissions = $studentSubmissionRepository->findAll();

        return $this->render('submition/index.html.twig', [
            'studentSubmissions' => $studentSubmissions,
        ]);
    }

    #[Route('/nomination', name: 'nomination')]
    public function nomination(StudentRepository $studentRepository): Response
    {
        // Get all students and sort them based on average grades from first to fifth year
        $students = $studentRepository->findAllSortedByAverageGrades();

        return $this->render('submition/nomination.html.twig', [
            'students' => $students,
        ]);
    }


    #[Route('//approve-student-submission/{id}', name: 'approve_student_submission')]
    public function approveStudentSubmission(StudentSubmission $studentSubmission): Response
    {
        // Logic to approve the student submission
        // For example, you can change the status to "accepted".
        // Save the changes to the database using the EntityManager or your preferred method.
        $studentSubmission->setStatus(StudentSubmission::STATUS_ACCEPTED);

        // Assuming you have Doctrine EntityManager injected into the controller
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        // Redirect back to the nominations page
        return $this->redirectToRoute('app_submition');
    }
}


