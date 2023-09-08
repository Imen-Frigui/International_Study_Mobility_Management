<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LoginFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\StudentRepository;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class StudentLoginController extends AbstractController
{

    #[Route('/student/login', name: 'student_login')]
    public function login(Request $request, StudentRepository $studentRepository): Response
    {
       $form = $this->createForm(LoginFormType::class);
        $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Get the data from the form
        $formData = $form->getData();
        $identifiant = $formData['identifiant'];
        $cin = $formData['cin'];

        // Query the database to find a student with the provided identifiant
        $student = $studentRepository->findOneBy(['identifiant' => $formData['identifiant']]);

        if (!$student) {
            throw new CustomUserMessageAuthenticationException('Invalid credentials.');
        }

        // Check if the provided cin matches the cin in the database
        if ($cin !== $student->getCin()) {
            throw new CustomUserMessageAuthenticationException('Invalid credentials.');
        }

        // Authentication successful, redirect to the app_program or another page
        // You may also need to create and manage user sessions here
        // After successful authentication
        $this->get('session')->set('student', $student);
        dump($this->get('session')->get('student'));
        return $this->redirectToRoute('app_program');

    }

    return $this->render('student/login.html.twig', [
        'form' => $form->createView(),
    ]);
}




}



