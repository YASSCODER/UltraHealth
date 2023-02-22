<?php

namespace App\Controller;

use App\Entity\Passe;
use App\Form\PasseType;
use App\Repository\PasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/passe')]
class PasseController extends AbstractController
{
    #[Route('/', name: 'app_passe_index', methods: ['GET'])]
    public function index(PasseRepository $passeRepository): Response
    {
        return $this->render('passe/index.html.twig', [
            'passes' => $passeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_passe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PasseRepository $passeRepository): Response
    {
        $passe = new Passe();
        $form = $this->createForm(PasseType::class, $passe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passeRepository->save($passe, true);

            return $this->redirectToRoute('app_passe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('passe/new.html.twig', [
            'passe' => $passe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_passe_show', methods: ['GET'])]
    public function show(Passe $passe): Response
    {
        return $this->render('passe/show.html.twig', [
            'passe' => $passe,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_passe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Passe $passe, PasseRepository $passeRepository): Response
    {
        $form = $this->createForm(PasseType::class, $passe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passeRepository->save($passe, true);

            return $this->redirectToRoute('app_passe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('passe/edit.html.twig', [
            'passe' => $passe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_passe_delete', methods: ['POST'])]
    public function delete(Request $request, Passe $passe, PasseRepository $passeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $passe->getId(), $request->request->get('_token'))) {
            $passeRepository->remove($passe, true);
        }

        return $this->redirectToRoute('app_passe_index', [], Response::HTTP_SEE_OTHER);
    }
}
