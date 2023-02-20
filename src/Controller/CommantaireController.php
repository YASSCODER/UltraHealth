<?php

namespace App\Controller;

use App\Entity\Commantaire;
use App\Form\CommantaireType;
use App\Repository\CommantaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commantaire')]
class CommantaireController extends AbstractController
{
    #[Route('/', name: 'app_commantaire_index', methods: ['GET'])]
    public function index(CommantaireRepository $commantaireRepository): Response
    {
        return $this->render('commantaire/index.html.twig', [
            'commantaires' => $commantaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commantaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommantaireRepository $commantaireRepository): Response
    {
        $commantaire = new Commantaire();
        $form = $this->createForm(CommantaireType::class, $commantaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commantaireRepository->save($commantaire, true);

            return $this->redirectToRoute('app_commantaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commantaire/new.html.twig', [
            'commantaire' => $commantaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commantaire_show', methods: ['GET'])]
    public function show(Commantaire $commantaire): Response
    {
        return $this->render('commantaire/show.html.twig', [
            'commantaire' => $commantaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commantaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commantaire $commantaire, CommantaireRepository $commantaireRepository): Response
    {
        $form = $this->createForm(CommantaireType::class, $commantaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commantaireRepository->save($commantaire, true);

            return $this->redirectToRoute('app_commantaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commantaire/edit.html.twig', [
            'commantaire' => $commantaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commantaire_delete', methods: ['POST'])]
    public function delete(Request $request, Commantaire $commantaire, CommantaireRepository $commantaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commantaire->getId(), $request->request->get('_token'))) {
            $commantaireRepository->remove($commantaire, true);
        }

        return $this->redirectToRoute('app_commantaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
