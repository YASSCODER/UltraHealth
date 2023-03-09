<?php

namespace App\Controller;

use App\Entity\Ingrediant;
use App\Form\IngrediantType;
use App\Repository\IngrediantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;
use Doctrine\Persistence\ManagerRegistry;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;
use Endroid\QrCode\Label\Font\Not;

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
    #[Route('/c', name: 'app_ingrediantfront_index', methods: ['GET'])]
    public function indexc(IngrediantRepository $ingrediantRepository): Response
    {
        return $this->render('ingrediant/indexfront.html.twig', [
            'ingrediants' => $ingrediantRepository->findAll(),
        ]);
    }
    
    #[Route('/search', name: 'search_ingrediants', methods: ['GET','POST'])]
    public function searchIngrediants(Request $request, IngrediantRepository $ingrediantRepository)
    {
        $searchQuery = $request->query->get('searchQuery', '');
        
        $ingrediants = $ingrediantRepository->searchByTitre($searchQuery);
        
        return $this->render('ingrediant/searchresult.html.twig', [
            'ingrediants' => $ingrediants,
        ]);
    }
    
    #[Route('/searchadmin', name: 'search_ingrediantadmin', methods: ['GET','POST'])]
    public function searchIngrediantadmin(Request $request, IngrediantRepository $ingrediantRepository)
    {
        $searchQueryadmin = $request->query->get('searchQueryadmin', '');
        
        $ingrediants = $ingrediantRepository->searchByTitre($searchQueryadmin);
        
        return $this->render('ingrediant/searchresultadmin.html.twig', [
            'ingrediants' => $ingrediants,
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
    #[Route('/c/QrCode/{id}', name: 'app_QrCode')]
    public function qrCode(ManagerRegistry $doctrine, $id, IngrediantRepository $Ingrediant)
    {
        return $this->render("ingrediant/qrcodeingrediant.html.twig", ['id' => $id]);
    }

    #[Route('/c/QrCode/generate/{id}', name: 'app_qringrediant_codes')]
    public function qrGenerator(ManagerRegistry $doctrine, $id, IngrediantRepository $Ingrediant)
    {
        $em = $doctrine->getManager();
        $res = $Ingrediant->find($id);
      //  $qrcode = QrCode::create($res->getNom() .  " Et le prix est: " . $res->getPrix())
        $qrcode = QrCode::create( " - Votre fiche Ingrediant est:". $res->getId() )

            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        $writer = new PngWriter();
        return new Response($writer->write($qrcode)->getString(),
            Response::HTTP_OK,
            ['content-type' => 'image/png']
        );

    }

    #[Route('/{id}', name: 'app_ingrediant_show', methods: ['GET'])]
    public function show(Ingrediant $ingrediant): Response
    {
        return $this->render('ingrediant/show.html.twig', [
            'ingrediant' => $ingrediant,
        ]);
    }
    #[Route('/c/{id}', name: 'app_ingrediantfront_show', methods: ['GET'])]
    public function showc(Ingrediant $ingrediant): Response
    {
        return $this->render('ingrediant/showfront.html.twig', [
            'ingrediant' => $ingrediant,
        ]);
    }
    #[Route('/c/{id}/pdf', name: 'app_pdf_ingrediantfront_show', methods: ['GET'])]
    public function indexx(Ingrediant $ingrediant)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('ingrediant/ingrediantpdf.html.twig', [
            'ingrediant' => $ingrediant,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();
       
        $publicDirectory = $this->getParameter('ingrediant_pdf_directory');

        $pdfFilepath =  $publicDirectory . '/' . uniqid() . '.pdf';

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);
        
        // Send some text response
        return new Response("The PDF file has been succesfully generated !");
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
