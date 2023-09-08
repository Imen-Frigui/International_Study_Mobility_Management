<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramSubmissionRepository;
use App\Repository\NotificationRepository;
use App\Entity\Notification;
use App\Entity\Student;




class StudentController extends AbstractController
{

    #[Route('/student/submissions', name: 'student_submissions')]
    public function viewSubmissions(ProgramSubmissionRepository $programSubmissionRepository, NotificationRepository $notificationRepository): Response
    {
        // Fetch submissions for student with ID 2
        $studentId = 1;
        $submissions = $programSubmissionRepository->findBy(['student' => $studentId]);

        $student = $this->get('session')->get('student');
        // Check if the student is in the session
        if (!$student) {
            // Handle the case where the student is not found in the session, maybe redirect to the login page
            return $this->redirectToRoute('student_login');
        }
        $notifications = $notificationRepository->findBy(['student' => $student, 'hasRead' => false]);
        
        return $this->render('student/view_submissions.html.twig', [
            'submissions' => $submissions,
            'notifications' => $notifications,
            'student' => $student,
        ]);
    }

    #[Route('/view-unread-notifications', name: 'view_unread_notifications')]
    public function viewUnreadNotifications(NotificationRepository $notificationRepository): Response
    {
        $student = $this->get('session')->get('student');
        // Check if the student is in the session
        if (!$student) {
            // Handle the case where the student is not found in the session, maybe redirect to the login page
            return $this->redirectToRoute('student_login');
        }

        if (!$student) {
            throw $this->createNotFoundException('Student not found');
        }
        // Fetch all unread notifications for the student
        $notifications = $notificationRepository->findBy(['student' => $student, 'hasRead' => false]);

        return $this->render('student/unread_notifications.html.twig', [
            'notifications' => $notifications,
            'student' => $student,
            
        ]);
    }


    #[Route('/view-notification/{id}', name: 'view_notification')]
    public function viewNotification(int $id, NotificationRepository $notificationRepository): Response
    {
        $notification = $notificationRepository->find($id);

        if (!$notification) {
            throw $this->createNotFoundException('Notification not found');
        }

        $student = $this->getDoctrine()->getRepository(Student::class)->find(1);
        $notifications = $notificationRepository->findBy(['student' => $student, 'hasRead' => false]);

        // Mark the notification as read
        $notification->setHasRead(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();


        // You can redirect to a page that displays submission details
        return $this->redirectToRoute('student_submissions');
    }





}
