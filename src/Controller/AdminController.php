<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Program;
use App\Entity\Notification;
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
    public function reviewSubmissions(Request $request,int $id, ProgramRepository $programRepository, ProgramSubmissionRepository $programSubmissionRepository): Response
    {
        // Find the program
        $program = $programRepository->find($id);
    
        if (!$program) {
            throw $this->createNotFoundException('Program not found');
        }
    
        // Get the sorting parameter from the query string (default to 'averageGrade')
        $sort = $request->query->get('sort', 'averageGrade');
        // Fetch the submissions for this program
        $submissions = $programSubmissionRepository->findBy(['program' => $program]);
        // Sort the submissions based on the selected criteria
        if ($sort === 'averageGrade') {
            usort($submissions, function ($a, $b) {
                $averageGradeA = $a->getStudent()->getAverageGrade();
                $averageGradeB = $b->getStudent()->getAverageGrade();
                return $averageGradeB <=> $averageGradeA; // Descending order
            });

        } elseif ($sort === 'firstYear') {
            usort($submissions, function ($a, $b) {
                $gradeA = $a->getStudent()->getFirstYearGrade();
                $gradeB = $b->getStudent()->getFirstYearGrade();
                return $gradeB <=> $gradeA; // Descending order
            });
    
        } elseif ($sort === 'secondYear') {
            usort($submissions, function ($a, $b) {
                $gradeA = $a->getStudent()->getSecondYearGrade();
                $gradeB = $b->getStudent()->getSecondYearGrade();
                return $gradeB <=> $gradeA; // Descending order
            });

        } elseif ($sort === 'thirdYear') {
            usort($submissions, function ($a, $b) {
                $gradeA = $a->getStudent()->getThirdYearGrade();
                $gradeB = $b->getStudent()->getThirdYearGrade();
                return $gradeB <=> $gradeA; // Descending order
            });

        } elseif ($sort === 'fourthYear') {
            usort($submissions, function ($a, $b) {
                $gradeA = $a->getStudent()->getFourthYearGrade();
                $gradeB = $b->getStudent()->getFourthYearGrade();
                return $gradeB <=> $gradeA; // Descending order
            });
        }

        // Sort the submissions based on the average grade of the associated student
      //  usort($submissions, function ($a, $b) {
        //    $averageGradeA = $a->getStudent()->getAverageGrade();
          //  $averageGradeB = $b->getStudent()->getAverageGrade();
            //return $averageGradeB <=> $averageGradeA; // Descending order
     //   });
    
        // Render a template to display the submissions
        return $this->render('program/review_submissions.html.twig', [
            'program' => $program,
            'submissions' => $submissions,
            'sort' => $sort, 
        ]);
    }    

    #[Route('/accept_submission/{id}', name: 'accept_submission')]
    public function acceptSubmission(int $id, ProgramSubmission $programSubmission, ProgramSubmissionRepository $programSubmissionRepository): Response
    {
        $programSubmission = $programSubmissionRepository->find($id);

        if (!$programSubmission) {
            throw $this->createNotFoundException('Submission not found');
        }

        // Set the submission status
        $programSubmission->setStatus(ProgramSubmission::STATUS_ACCEPTED);

        // Create a notification for the student
        $notification = new Notification();
        $notification->setMessage('Your submission request has been accepted');
        $notification->setStudent($programSubmission->getStudent());
        $notification->setHasRead(false); // Mark as unread
        $notification->setCreatedAt(new \DateTimeImmutable());
        $em = $this->getDoctrine()->getManager();
        $em->persist($notification);

        $em->flush();

        $this->addFlash('success', 'Submission accepted successfully.');

        return $this->redirectToRoute('review_submissions', ['id' => $programSubmission->getProgram()->getId()]);
    }

    #[Route('/reject_submission/{id}', name: 'reject_submission')]
    public function rejectSubmission(int $id, ProgramSubmission $programSubmission, ProgramSubmissionRepository $programSubmissionRepository): Response
    {
        $programSubmission = $programSubmissionRepository->find($id);

        if (!$programSubmission) {
            throw $this->createNotFoundException('Submission not found');
        }

        $programSubmission->setStatus(ProgramSubmission::STATUS_BANNED);
       
        // Create a notification for the student
        $notification = new Notification();
        $notification->setMessage('Your submission request has been rejected');
        $notification->setStudent($programSubmission->getStudent());
        $notification->setHasRead(false); // Mark as unread
        $notification->setCreatedAt(new \DateTimeImmutable());
        $em = $this->getDoctrine()->getManager();
        $em->persist($notification);

        $em->flush();

        $this->addFlash('danger', 'Submission rejected.');

        return $this->redirectToRoute('review_submissions', ['id' => $programSubmission->getProgram()->getId()]);
    }

    #[Route('/admin/stats', name: 'programs_stats')]
    public function programStat(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        $programData = [];

        foreach ($programs as $program) {
            $programData[] = [
                'title' => $program->getTitle(),
                'accepted' => $programRepository->getStudentStatusCount($program->getId(), 'accepted'),
                'pending' => $programRepository->getStudentStatusCount($program->getId(), 'pending'),
                'rejected' => $programRepository->getStudentStatusCount($program->getId(), 'rejected')
            ];
        }

        return $this->render('admin/stat.html.twig', [
            'programData' => json_encode($programData)
        ]);
    }
}
