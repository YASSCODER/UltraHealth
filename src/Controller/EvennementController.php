<?php

namespace App\Controller;

use App\Entity\Evennement;
use App\Entity\Passe;
use App\Entity\User;
use App\Form\Evennement1Type;
use App\Repository\EvennementRepository;
use App\Repository\PasseRepository;
use App\Repository\EventCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;
//use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

#[Route('/evennement')]
class EvennementController extends AbstractController
{
    #[Route('/', name: 'app_evennement_index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator, EvennementRepository $evennementRepository): Response
    {
        $query = $evennementRepository->createQueryBuilder('p')
            ->orderBy('p.titre', 'ASC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            1
        );

        return $this->render('evennement/index.html.twig', [

            'evennements' => $pagination,

        ]);
    }

    #[Route('/fronti/{id}', name: 'app_evennement_front_show', methods: ['GET'])]
    public function showF(Evennement $evennement): Response
    {
        return $this->render('evennement/frontshow.html.twig', [
            'evennement' => $evennement,
        ]);
    }
    #[Route('/fronti/{id}/update', name: 'app_evennement_update', methods: ['POST', 'GET'])]
    public function updateNbreParticipant(Request $request, Evennement $event, PasseRepository $passeRepository): Response
    {
        $nbrP = $request->query->get('nbrP');
        $p = $request->query->get('prix');

        if ($nbrP) {
            $entityManager = $this->getDoctrine()->getManager();
            $event->setNbrPasse($nbrP - 1);
            $entityManager->persist($event);
            $entityManager->flush();

            if ($p) {
                $passe = new Passe($p, $event);
                $entityManager = $this->getDoctrine()->getManager();
                $passe->setPrix($p);
                $passeRepository->save($passe, true);
                $entityManager->persist($passe);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_evennement_front_show', ['id' => $event->getId()]);
        }

        return $this->redirectToRoute('app_evennement_index');
    }

    #[Route('/fronti', name: 'app_evennement_front_index', methods: ['GET'])]
    public function indexF(EvennementRepository $evennementRepository, EventCategoryRepository $catRepo, Request $request): Response
    {
        $categories = $catRepo->findAll();
        $filters = $request->get("categories");
        $evennements = $evennementRepository->findEventsByEndDate($filters);

        if ($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('evennement/_contentEventB.html.twig', [
                    'evennements' => $evennements,

                ])
            ]);
        }


        return $this->render('evennement/frontindex.html.twig', [
            'evennements' => $evennements,
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'app_evennement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EvennementRepository $evennementRepository): Response
    {
        $evennement = new Evennement();
        $form = $this->createForm(Evennement1Type::class, $evennement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evennementRepository->save($evennement, true);

            $imageFile = $form->get('eventimg')->getData();

            if ($imageFile) {

                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('event_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle file upload error
                }

                $evennement->setEventimg($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evennement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evennement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evennement/new.html.twig', [
            'evennement' => $evennement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evennement_show', methods: ['GET'])]
    public function show(Evennement $evennement): Response
    {
        return $this->render('evennement/show.html.twig', [
            'evennement' => $evennement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evennement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evennement $evennement, EvennementRepository $evennementRepository): Response
    {
        $form = $this->createForm(Evennement1Type::class, $evennement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evennementRepository->save($evennement, true);

            return $this->redirectToRoute('app_evennement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evennement/edit.html.twig', [
            'evennement' => $evennement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evennement_delete', methods: ['POST'])]
    public function delete(Request $request, Evennement $evennement, EvennementRepository $evennementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $evennement->getId(), $request->request->get('_token'))) {
            $evennementRepository->remove($evennement, true);
        }

        return $this->redirectToRoute('app_evennement_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/fronti/{id}/part', name: 'app_evennement_part', methods: ['POST', 'GET'])]
    public function part(Request $request, PasseRepository $passeRepository, Evennement $evennement, Passe $passe): Response
    {
        $p = $request->query->get('prix');
        if ($p) {
            $passe = new Passe($p);
            $entityManager = $this->getDoctrine()->getManager();
            $passe->setPrix($p);
            $entityManager->persist($passe);
            $entityManager->flush();

            return $this->redirectToRoute('app_evennement_front_show', ['id' => $evennement->getId()]);
        }
    }


    #[Route('/fronti', name: 'event_search')]
    public function searchAction(Request $request, EntityManagerInterface $em)
    {

        $requestString = $request->get('q');
        $event =  $em->getRepository(Evennement::class)->findEntitiesByString($requestString);

        if (!count($event)) {
            $result['events']['error'] = "Aucun evennement trouvé  ";
        } else {
            $result['events'] = $this->getRealEntities($event);
        }

        return new Response(json_encode($result));
    }
    public function getRealEntities($events)
    {
        foreach ($events as $event) {
            $realEntities[$event->getId()] = [$event->getTitre(), $event->getZone()];
        }
        return $realEntities;
    }

    /*
    public function indexpage(Request $request, EntityManagerInterface $entityManager)
    {
        $query = $entityManager->createQueryBuilder()
            ->select('p')
            ->from(Evennement::class, 'p')
            ->getQuery();
        $paginator = new Paginator($query);
        // set the page number and number of items per page
        $paginator
            ->setCurrentPageNumber($request->query->getInt('page', 1))
            ->setItemCountPerPage(10);
        return $this->render('product/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }
*/
    /*public function indexpage(Request $request, PaginatorInterface $paginator)
    {
        $query = $entityManager->createQueryBuilder()
            ->select('p')
            ->from(Product::class, 'p')
            ->getQuery();
    
        $paginator = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // page number
            10 // items per page
        );
    
        return $this->render('product/index.html.twig', [
            'paginator' => $paginator,
        ]);
    }*/


    /**
     * @Route("/produitFront", name="display_prodFront")
     */
    /* public function indexFront(Request $request, PaginatorInterface $paginator, EvennementRepository $evennementRepository): Response
    {
        $query = $evennementRepository->createQueryBuilder('p')
            ->orderBy('p.nomP', 'ASC')
            ->getQuery();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('produit/indexFront.html.twig', [
            'listP' => $pagination,
            'Produit' => $pagination,
        ]);
    }*/

    #[Route('/frontPagi', name: 'app_evennement_paginator', methods: ['GET'])]
    public function indexFront(Request $request, PaginatorInterface $paginator, EvennementRepository $EvennementRepository): Response
    {


        $query = $EvennementRepository->createQueryBuilder('evennement')
            ->orderBy('evennement.id', 'ASC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('evennement/indexFront.html.twig', [
            'listP' => $pagination,
            'Produit' => $pagination,

        ]);
    }

    #[Route('/page', name: 'app_article_index', methods: ['GET'])]
    public function indexP(Request $request, EvennementRepository $evennementRepository, PaginatorInterface $paginator): Response
    {
        $query = $evennementRepository->createQueryBuilder('p')
            ->orderBy('p.titre', 'ASC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('evennement/indexFront.html.twig', [
            'listP' => $pagination,
            'evennement' => $pagination,

        ]);
    }
}