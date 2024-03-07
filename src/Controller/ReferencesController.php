<?php

namespace App\Controller;

use App\Entity\References;
use App\Form\ReferencesType;
use App\Repository\ReferencesRepository;
use App\Service\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ReferencesService;

#[Route('/references')]
class ReferencesController extends AbstractController
{

    private $referencesService; // Déclarez le service

    public function __construct(ReferencesService $referencesService) // Injectez le service dans le constructeur
    {
        $this->referencesService = $referencesService;
    }




    #[Route('/', name: 'app_references_index', methods: ['GET'])]
    public function index(ReferencesRepository $referencesRepository): Response
    {
        return $this->render('references/index.html.twig', [
            'references' => $referencesRepository->findAll(),
        ]);
    }

//    #[Route('/new', name: 'app_references_new', methods: ['GET', 'POST'])]
//    public function new(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $reference = new References();
//
//        $form = $this->createForm(ReferencesType::class, $reference);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager->persist($reference);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('app_references_index', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->render('references/new.html.twig', [
//            'reference' => $reference,
//            'form' => $form,
//        ]);
//    }


# test service pour créer une reference
    #[Route('/new', name: 'app_references_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $reference = $this->referencesService->createReference('Nom de la référence');

        $form = $this->createForm(ReferencesType::class, $reference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->referencesService->saveReference($reference);

            return $this->redirectToRoute('app_references_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('references/new.html.twig', [
            'reference' => $reference,
            'form' => $form,
        ]);
    }


    #[Route('/detail/{id}', name: 'app_references_show', methods: ['GET'])]
    public function show(References $reference): Response
    {
        return $this->render('references/show.html.twig', [
            'reference' => $reference,
        ]);
    }

    #[Route('/message-service', name: 'app_references_message-service')]
    public function messageServiceReference(MessageService $messageService): Response
    {
//        $test = $messageService->AfficherMessage();

        return new Response($messageService->AfficherMessage());

    }

    #[Route('/{id}/edit', name: 'app_references_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, References $reference, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReferencesType::class, $reference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_references_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('references/edit.html.twig', [
            'reference' => $reference,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_references_delete', methods: ['POST'])]
    public function delete(Request $request, References $reference, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reference->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reference);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_references_index', [], Response::HTTP_SEE_OTHER);
    }
}
