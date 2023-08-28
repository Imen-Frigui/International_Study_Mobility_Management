<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Document;
use App\Form\DocumentType;
use Symfony\Component\HttpFoundation\Request;

class DocumentController extends AbstractController
{
    #[Route('/documents', name: 'document_index')]
    public function index(): Response
    {
        $documents = $this->getDoctrine()->getRepository(Document::class)->findAll();

        return $this->render('document/index.html.twig', [
            'documents' => $documents,
        ]);
    }
    
    #[Route('/document/new', name: 'document_new')]
    public function newDocument(Request $request): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload (if applicable)
            $file = $form->get('path')->getData();
            if ($file) {
                // Generate a unique name for the file
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                // Move the file to the desired directory
                $file->move(
                    $this->getParameter('document_directory'), // Define this parameter in services.yaml
                    $fileName
                );

                // Set the path property of the document entity
                $document->setPath($fileName);
            }

            // Save the document to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($document);
            $entityManager->flush();

            // Redirect to a success page or show a success message
            // Example:
            $this->addFlash('success', 'Document created successfully!');
            return $this->redirectToRoute('document_list');
        }

        return $this->render('document/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/document/edit/{id}', name: 'document_edit')]
    public function editDocument(Request $request, Document $document): Response
    {
        $form = $this->createForm(DocumentType::class, $document);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload (if applicable), similar to the newDocument action

            // Save the updated document to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            // Redirect to a success page or show a success message
            // Example:
            $this->addFlash('success', 'Document updated successfully!');
            return $this->redirectToRoute('document_list');
        }

        return $this->render('document/edit.html.twig', [
            'form' => $form->createView(),
            'document' => $document,
        ]);
    }

}
