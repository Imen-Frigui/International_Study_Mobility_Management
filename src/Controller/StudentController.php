<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramSubmissionRepository;
use App\Repository\NotificationRepository;

class StudentController extends AbstractController
{

    #[Route('/student/submissions', name: 'student_submissions')]
    public function viewSubmissions(ProgramSubmissionRepository $programSubmissionRepository): Response
    {
        // Fetch submissions for student with ID 2
        $studentId = 2;
        $submissions = $programSubmissionRepository->findBy(['student' => $studentId]);

        return $this->render('student/view_submissions.html.twig', [
            'submissions' => $submissions,
        ]);
    }

    #[Route('/view-unread-notifications', name: 'view_unread_notifications')]
    public function viewUnreadNotifications(NotificationRepository $notificationRepository): Response
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->find(1);

        if (!$student) {
            throw $this->createNotFoundException('Student not found');
        }
        // Fetch all unread notifications for the student
        $notifications = $notificationRepository->findBy(['student' => $student, 'hasRead' => false]);

        return $this->render('student/unread_notifications.html.twig', [
            'notifications' => $notifications,
        ]);
    }
}
