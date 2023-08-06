<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\StudentSubmission;

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
}


