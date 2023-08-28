<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Program;
use App\Form\ProgramType;



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
}