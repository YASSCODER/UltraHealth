<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\PlatType;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/plat')]
class PlatController extends AbstractController
{
    #[Route('/', name: 'app_plat_index', methods: ['GET'])]
    public function index(PlatRepository $platRepository): Response
    {
        return $this->render('plat/index.html.twig', [
            'plats' => $platRepository->findAll(),
        ]);
    }
    #[Route('/p', name: 'app_platfront_index', methods: ['GET'])]
    public function indexp(PlatRepository $platRepository): Response
    {
        return $this->render('plat/indexfront.html.twig', [
            'plats' => $platRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_plat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlatRepository $platRepository): Response
    {
        $plat = new Plat();
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $platRepository->save($plat, true);

            return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plat/new.html.twig', [
            'plat' => $plat,
            'form' => $form,
        ]);
    }
    #[Route('/search', name: 'search_plats', methods: ['GET','POST'])]
    public function searchPlats(Request $request, PlatRepository $platRepository)
    {
        $searchQuery = $request->query->get('searchQuery', '');
        
        $plats = $platRepository->searchByTitre($searchQuery);
        
        return $this->render('plat/searchresult.html.twig', [
            'plats' => $plats,
        ]);
    }
    #[Route('/searchadmin', name: 'search_platadmin', methods: ['GET','POST'])]
    public function searchPlatadmin(Request $request, PlatRepository $platRepository)
    {
        $searchQueryadmin = $request->query->get('searchQueryadmin', '');
        
        $plats = $platRepository->searchByTitre($searchQueryadmin);
        
        return $this->render('plat/searchresultadmin.html.twig', [
            'plats' => $plats,
        ]);
    }

    #[Route('/{id}', name: 'app_plat_show', methods: ['GET'])]
    public function show(Plat $plat): Response
    {
        return $this->render('plat/show.html.twig', [
            'plat' => $plat,
        ]);
    }
    #[Route('/p/{id}', name: 'app_platfront_show', methods: ['GET'])]
    public function showc(Plat $plat): Response
    {
        return $this->render('plat/showfront.html.twig', [
            'plat' => $plat,
        ]);
    }
    #[Route('/p/{id}/pdf', name: 'app_pdf_platfront_show', methods: ['GET'])]
    public function indexx(Plat $plat)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('plat/platpdf.html.twig', [
            'plat' => $plat,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();
       
        $publicDirectory = $this->getParameter('plat_pdf_directory');

        $pdfFilepath =  $publicDirectory . '/' . uniqid() . '.pdf';

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);
        
        // Send some text response
        return new Response("The PDF file has been succesfully generated !");
    }

    #[Route('/{id}/edit', name: 'app_plat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Plat $plat, PlatRepository $platRepository): Response
    {
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $platRepository->save($plat, true);

            return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plat/edit.html.twig', [
            'plat' => $plat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plat_delete', methods: ['POST'])]
    public function delete(Request $request, Plat $plat, PlatRepository $platRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plat->getId(), $request->request->get('_token'))) {
            $platRepository->remove($plat, true);
        }

        return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
    }
}
