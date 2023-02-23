<?php

namespace App\Controller;

use App\Entity\Ingrediant;
use App\Form\IngrediantType;
use App\Repository\IngrediantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ingrediant')]
class IngrediantController extends AbstractController
{
    #[Route('/', name: 'app_ingrediant_index', methods: ['GET'])]
    public function index(IngrediantRepository $ingrediantRepository): Response
    {
        return $this->render('ingrediant/index.html.twig', [
            'ingrediants' => $ingrediantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ingrediant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, IngrediantRepository $ingrediantRepository): Response
    {
        $ingrediant = new Ingrediant();
        $form = $this->createForm(IngrediantType::class, $ingrediant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingrediantRepository->save($ingrediant, true);

            return $this->redirectToRoute('app_ingrediant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ingrediant/new.html.twig', [
            'ingrediant' => $ingrediant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ingrediant_show', methods: ['GET'])]
    public function show(Ingrediant $ingrediant): Response
    {
        return $this->render('ingrediant/show.html.twig', [
            'ingrediant' => $ingrediant,
        ]);
    }

        #[Route('/{id}/edit', name: 'app_ingrediant_edit', methods: ['GET','POST'])]
        public function edit(Request $request, Ingrediant $ingrediant, IngrediantRepository $ingrediantRepository): Response
        {
            $form = $this->createForm(IngrediantType::class, $ingrediant);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $ingrediantRepository->save($ingrediant, true);

                return $this->redirectToRoute('app_ingrediant_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('ingrediant/edit.html.twig', [
                'ingrediant' => $ingrediant,
                'form' => $form,
            ]);
        }

    #[Route('/{id}', name: 'app_ingrediant_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Ingrediant $ingrediant, IngrediantRepository $ingrediantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ingrediant->getId(), $request->request->get('_token'))) {
            $ingrediantRepository->remove($ingrediant, true);
        }

        return $this->redirectToRoute('app_ingrediant_index', [], Response::HTTP_SEE_OTHER);
    }
}
