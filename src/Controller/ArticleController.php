<?php

namespace App\Controller;
use DateTimeImmutable;
use App\Entity\Article;
use App\Entity\Commantaire;
use App\Form\ArticleType;
use App\Form\CommantaireType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use SebastianBergmann\Type\NullType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommantaireRepository;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/template', name: 'xxxx')]
    public function affi(): Response
    {
        return $this->render('template.html.twig');
    }
    #[Route('/template1', name: 'xxxx')]
    public function affic(): Response
    {
        return $this->render('template1.html.twig');
    }

    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository,): Response
{
    
    
    return $this->render('article/index.html.twig', [
        'articles' => $articleRepository->findAll(),
        
    ]);
}
#[Route('/back', name: 'app_article_backindex', methods: ['GET'])]
public function backindex(ArticleRepository $articleRepository,): Response
{


return $this->render('article/backindex.html.twig', [
    'articles' => $articleRepository->findAll(),
    
]);
}


    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticleRepository $articleRepository): Response
    {
        $article = new Article();
        

        
        $createdAt = new DateTimeImmutable();
        $article->setCreatedAt($createdAt);  
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clean=$article->gettitre();
            $cleaninput=$articleRepository->clean_input($clean);
            $article->setTitre($cleaninput);
            $clean1=$article->getDescription();
            $cleaninput1=$articleRepository->clean_input($clean1);
            $article->setDescription($cleaninput1);
            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }
    #[Route('/backnew', name: 'app_article_backnew', methods: ['GET', 'POST'])]
    public function backnew(Request $request, ArticleRepository $articleRepository): Response
    {
        $article = new Article();
        

        
        $createdAt = new DateTimeImmutable();
        $article->setCreatedAt($createdAt);  
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clean=$article->gettitre();
            $cleaninput=$articleRepository->clean_input($clean);
            $article->setTitre($cleaninput);
            $clean1=$article->getDescription();
            $cleaninput1=$articleRepository->clean_input($clean1);
            $article->setDescription($cleaninput1);
            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_article_backindex', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/backnew.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(CommantaireRepository $commantaireRepository, Article $article, Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $repository = $entityManager->getRepository(Article::class);
        $article = $repository->find($id);
    
        $commantaire = new Commantaire();
        $commantaire->setPoste($article);
        $createdAt = new DateTimeImmutable();
        $commantaire->setCreatedAt($createdAt);
    
        $commantaireForm = $this->createForm(CommantaireType::class, $commantaire);
        $commantaireForm->handleRequest($request);
    
        if ($commantaireForm->isSubmitted()&& $commantaireForm->isValid()) {
            $commantaireRepository->save($commantaire, true);

            return $this->redirectToRoute('app_commantaire_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'commantaireForm' => $commantaireForm->createView(),
            'commantaire' => $commantaire,
        ]);
    }
        #[Route('/back/{id}', name: 'app_article_backshow', methods: ['GET'])]
    public function backshow(CommantaireRepository $commantaireRepository, Article $article, Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $repository = $entityManager->getRepository(Article::class);
        $article = $repository->find($id);
    
        $commantaire = new Commantaire();
        $commantaire->setPoste($article);
        $createdAt = new DateTimeImmutable();
        $commantaire->setCreatedAt($createdAt);
    
        $commantaireForm = $this->createForm(CommantaireType::class, $commantaire);
        $commantaireForm->handleRequest($request);
    
        if ($commantaireForm->isSubmitted()&& $commantaireForm->isValid()) {
            $commantaireRepository->save($commantaire, true);

            return $this->redirectToRoute('app_commantaire_backindex', [], Response::HTTP_SEE_OTHER);
        }
        
    
        return $this->render('article/backshow.html.twig', [
            'article' => $article,
            'commantaireForm' => $commantaireForm->createView(),
            'commantaire' => $commantaire,
        ]);
    }

    #[Route('/edit/{id?6}', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(ArticleRepository $articleRepository,Request $request, ManagerRegistry $doctrin ,$id): Response
    {
         $reposetery=$doctrin->getRepository(Article::class);


        $article=$reposetery->find($id);
        $etUpdatedAt = new DateTimeImmutable();
        $article->setUpdatedAt($etUpdatedAt);
        
        $articles = $articleRepository->findAll();
       
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
           // $articleRepository->save($article, true);
           $clean=$article->gettitre();
            $cleaninput=$articleRepository->clean_input($clean);
            $article->setTitre($cleaninput);
            $clean1=$article->getDescription();
            $cleaninput1=$articleRepository->clean_input($clean1);
            $article->setDescription($cleaninput1);
           $manager=$doctrin->getManager();
           $manager->persist($article);
           $manager->flush();
           
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }
    #[Route('/backedit/{id?6}', name: 'app_article_backedit', methods: ['GET', 'POST'])]
    public function backedit(ArticleRepository $articleRepository,Request $request, ManagerRegistry $doctrin ,$id): Response
    {
         $reposetery=$doctrin->getRepository(Article::class);


        $article=$reposetery->find($id);
        $etUpdatedAt = new DateTimeImmutable();
        $article->setUpdatedAt($etUpdatedAt);
        
        $articles = $articleRepository->findAll();
       
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $clean=$article->gettitre();
            $cleaninput=$articleRepository->clean_input($clean);
            $article->setTitre($cleaninput);
            $clean1=$article->getDescription();
            $cleaninput1=$articleRepository->clean_input($clean1);
            $article->setDescription($cleaninput1);
           // $articleRepository->save($article, true);
           $manager=$doctrin->getManager();
           $manager->persist($article);
           $manager->flush();
           
            return $this->redirectToRoute('app_article_backindex', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/backedit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }










}
