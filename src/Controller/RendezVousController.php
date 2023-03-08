<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\GmailTransport;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;




#[Route('/rendez/vous')]
class RendezVousController extends AbstractController
{
    #[Route('/', name: 'app_rendez_vous_index', methods: ['GET'])]
    public function index(RendezVousRepository $rendezVousRepository,Request $request, PaginatorInterface $paginator): Response

    {
        $query = $rendezVousRepository->createQueryBuilder('p')
        ->orderBy('p.id', 'ASC')
        ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            1
        );  

        return $this->render('rendez_vous/index.html.twig', [
            'rendez_vouses' => $pagination,
        ]);
    }

    #[Route('/back', name: 'app_rendez_vous_back_index', methods: ['GET'])]
    public function indexback(RendezVousRepository $rendezVousRepository ,Request $request, PaginatorInterface $paginator): Response
    {
        $query = $rendezVousRepository->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC')
            ->getQuery();

            $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                1
            );


        return $this->render('rendez_vous/indexback.html.twig', [
            'rendez_vouses' => $pagination,


        ]);
    }

  


    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    public function envoyerEmail()
    {
      //  $emailDestinataire = $rdv->getEmail();
        $email = (new Email())
            ->from('hamrouni.firas@esprit.tn')
            ->to('fyraasham1998@gmail.com')
            ->subject('UltraHealth')
            ->text(sprintf('Votre rendez-vous  a été enregistré avec succès'));
    
            try {
                $this->mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                // log the error or handle it in some way
                throw $e;
            }
    }

    
    public function votreMethode()
    {
        $rdv = new RendezVous();
        // ...
        $this->envoyerEmail($rdv);
    }




    #[Route('/new', name: 'app_rendez_vous_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RendezVousRepository $rendezVousRepository,MailerInterface $mailer
    ): Response
    {
            

        $rendezVou = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rendezVousRepository->save($rendezVou, true);

         

            return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendez_vous/new.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
        ]);
    }

  


    #[Route('/back/new', name: 'app_rendez_vous_back_new', methods: ['GET', 'POST'])]
    public function newback(Request $request, RendezVousRepository $rendezVousRepository): Response
    {
        $rendezVou = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rendezVousRepository->save($rendezVou, true);

            return $this->redirectToRoute('app_rendez_vous_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendez_vous/newback.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rendez_vous_show', methods: ['GET'])]
    public function show(RendezVous $rendezVou): Response
    {
        return $this->render('rendez_vous/show.html.twig', [
            'rendez_vou' => $rendezVou,
        ]);
    }

    #[Route('/back/{id}', name: 'app_rendez_vous_back_show', methods: ['GET'])]
    public function showback(RendezVous $rendezVou): Response
    {
        return $this->render('rendez_vous/showback.html.twig', [
            'rendez_vou' => $rendezVou,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rendez_vous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RendezVous $rendezVou, RendezVousRepository $rendezVousRepository): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rendezVousRepository->save($rendezVou, true);

            return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendez_vous/edit.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/back/{id}/edit', name: 'app_rendez_vous_back_edit', methods: ['GET', 'POST'])]
    public function editback(Request $request, RendezVous $rendezVou, RendezVousRepository $rendezVousRepository): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rendezVousRepository->save($rendezVou, true);

            return $this->redirectToRoute('app_rendez_vous_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rendez_vous/editback.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rendez_vous_delete', methods: ['POST'])]
    public function delete(Request $request, RendezVous $rendezVou, RendezVousRepository $rendezVousRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezVou->getId(), $request->request->get('_token'))) {
            $rendezVousRepository->remove($rendezVou, true);
        }

        return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('back/{id}', name: 'app_rendez_vous_back_delete', methods: ['POST'])]
    public function deleteback(Request $request, RendezVous $rendezVou, RendezVousRepository $rendezVousRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezVou->getId(), $request->request->get('_token'))) {
            $rendezVousRepository->remove($rendezVou, true);
        }

        return $this->redirectToRoute('app_rendez_vous_back_index', [], Response::HTTP_SEE_OTHER);
    }



   




    /*

    class RendezVousController extends AbstractController
{
    #[Route('/statistiques', name: 'app_statistiques')]
    public function statistiques(RendezVousRepository $RendezVousRepository): Response
    {
        // Récupération de tous les utilisateurs ayant un rôle "élève"
        $eleves = $utilisateurRepository->findBy(['role_util' => 'eleve']);
        

        // Nombre total d'activités
        $nbRendezVous = $RendezVousRepository->count([]);

        // Nombre d'élèves ayant participé à au moins une activité
        $nbElevesParticipes = 0;

        foreach ($eleves as $eleve) {
            // Comptage du nombre d'activités auxquelles l'élève a participé
            $nbActivitesParticipees = count($eleve->getListeActivites());

            if ($nbActivitesParticipees > 0) {
                $nbElevesParticipes++;
            }
        }

        // Calcul de la statistique
        $statistique = 0;

        if ($nbElevesParticipes > 0) {
            $statistique = round(($nbElevesParticipes / count($eleves)) * 100, 2);
        }

        // Affichage de la statistique
        return $this->render('consultation/editback.html.twig', [
            'nbActivites' => $nbActivites,
            'nbElevesParticipes' => $nbElevesParticipes,
            'statistique' => $statistique,
        ]);
    }
}

*/

}
