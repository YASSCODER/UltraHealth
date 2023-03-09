<?php

namespace App\Controller;
use DateTimeImmutable;
use App\Entity\Article;
use App\Entity\Commantaire;
use App\Form\CommantaireType;
use App\Repository\CommantaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ArticleRepository;
use App\Repository\UtilisateurRepository;;
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
    #[Route('/back', name: 'app_commantaire_backindex', methods: ['GET'])]
    public function backindex(CommantaireRepository $commantaireRepository): Response
    {
        return $this->render('commantaire/backindex.html.twig', [
            'commantaires' => $commantaireRepository->findAll(),
        ]);
    }

    #[Route('/new/{articleId}', name: 'app_commantaire_new', methods: ['GET', 'POST'])]
public function new(Request $request, articleRepository $articleRepository, UtilisateurRepository $userRepository, CommantaireRepository $commantaireRepository, $articleId): Response
{
    $article = $articleRepository->find($articleId);
    
    if (!$article) {
        throw $this->createNotFoundException('The article does not exist');
    }
    
    $commantaire = new Commantaire();
        
    $createdAt = new DateTimeImmutable();
    $commantaire->setCreatedAt($createdAt);
    $form = $this->createForm(CommantaireType::class, $commantaire);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $s = $commantaire->getUtilisateur();
        $username = $s->getNom();
        $userlastname = $s->getPrenom();
        $concat = $userlastname.$username;
        $commantaire->setTitre($concat);
        $commantaire->setPoste($article); // associate the comment with the article
        $commantaireRepository->save($commantaire, true);
        
        return $this->redirectToRoute('app_commantaire_index', [], Response::HTTP_SEE_OTHER);
    }
    
    return $this->renderForm('commantaire/new.html.twig', [
        'commantaire' => $commantaire,
        'form' => $form,
    ]);
}

        #[Route('/backnew', name: 'app_commantaire_backnew', methods: ['GET', 'POST'])]
        public function backnew(Request $request, CommantaireRepository $commantaireRepository): Response
        {
            
            $commantaire = new Commantaire();
            $createdAt = new DateTimeImmutable();
            $commantaire->setCreatedAt($createdAt);
            $form = $this->createForm(CommantaireType::class, $commantaire);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                
            $clean1=$commantaire->getDescription();
            $cleaninput1=$commantaireRepository->clean_input($clean1);
            $commantaire->setDescription($cleaninput1);
                $commantaireRepository->save($commantaire, true);
    
                return $this->redirectToRoute('app_commantaire_backindex', [], Response::HTTP_SEE_OTHER);
            }

        return $this->renderForm('commantaire/backnew.html.twig', [
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
    #[Route('/back/{id}', name: 'app_commantaire_backshow', methods: ['GET'])]
    public function backshow(Commantaire $commantaire): Response
    {
        return $this->render('commantaire/backshow.html.twig', [
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
    #[Route('/{id}/backedit', name: 'app_commantaire_backedit', methods: ['GET', 'POST'])]
    public function backedit(Request $request, Commantaire $commantaire, CommantaireRepository $commantaireRepository): Response
    {
        $form = $this->createForm(CommantaireType::class, $commantaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commantaireRepository->save($commantaire, true);

            return $this->redirectToRoute('app_commantaire_backindex', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commantaire/backedit.html.twig', [
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