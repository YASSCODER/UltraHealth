<?php

namespace App\Controller;

use App\Entity\Passe;
use App\Form\PasseType;
use App\Repository\PasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Knp\Snappy\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/passe')]
class PasseController extends AbstractController
{
    #[Route('/', name: 'app_passe_index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator, PasseRepository $passeRepository): Response
    {

        $query = $passeRepository->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('passe/index.html.twig', [

            'passes' => $pagination,

        ]);
    }

    #[Route('/fronti', name: 'app_passe_front_index', methods: ['GET'])]
    public function indexF(PasseRepository $passeRepository): Response
    {
        return $this->render('passe/frontindex.html.twig', [
            'passes' => $passeRepository->findAll(),
        ]);
    }

    #[Route('/fronti/{id}', name: 'app_passe_front_show', methods: ['GET'])]
    public function showF(Passe $passe): Response
    {
        return $this->render('passe/frontshow.html.twig', [
            'passe' => $passe,
        ]);
    }




    #[Route('/{id}', name: 'app_passe_show', methods: ['GET'])]
    public function show(Passe $passe): Response
    {
        return $this->render('passe/show.html.twig', [
            'passe' => $passe,
        ]);
    }
    #[Route('/{id}/pdf', name: 'app_passe_PDF', methods: ['GET'])]
    public function PDF(Passe $passe)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);



        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('passe/pdfPasse.html.twig', [
            'passe' => $passe,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $output = $dompdf->output();

        $publicDirectory = $this->getParameter('passe_pdf_directory');

        $pdfFilepath =  $publicDirectory . '/' . $passe->getCode() . '.pdf';
        if (!file_exists($pdfFilepath)) {
            file_put_contents($pdfFilepath, $output);
            return new Response("The PDF file has been succesfully generated !");
        } else {
            return new Response("The PDF file already exist");
        }



        // Output the generated PDF to Browser (force download)

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


    public function generateQrCode(string $data): Response
    {
        // Create a new QR code instance
        $qrCode = new QrCode($data);

        // Set the size of the QR code image
        $qrCode->setSize(300);

        // Set the margin of the QR code image
        $qrCode->setMargin(10);

        // Get the QR code image as a string
        $qrCodeImage = $qrCode->writeString();

        // Create a response object with the QR code image
        $response = new Response($qrCodeImage);

        // Set the content type header to image/png
        $response->headers->set('Content-Type', 'image/png');

        // Return the response object
        return $response;
    }


    /*
    #[Route('/QrCode/{id}', name: 'app_QrCode')]
    public function qrCode(ManagerRegistry $doctrine, $id, PasseRepository $passe)
    {
        return $this->render("front/GestionEvent/QR.html.twig", ['id' => $id]);
    }

    #[Route('/QrCode/generate/{id}', name: 'app_qr_codes')]
    public function qrGenerator(ManagerRegistry $doctrine, $id, PasseRepository $passeRepo)
    {
        $em = $doctrine->getManager();
        $res = $passeRepo->find($id);
      //  $qrcode = QrCode::create($res->getNom() .  " Et le prix est: " . $res->getPrix())
        $qrcode = QrCode::create( " - Votre referencre est:". $res->getReference() . " , et vous avez: " . $res->getNbrplace() . " place")

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

    }*/

    /*
public function pdfAction(Pdf $pdf)
{
    $html = $this->renderView('your-template.html.twig', [
        // ... your template data
    ]);

    $filename = 'your-filename.pdf';

    return new PdfResponse($pdf->getOutputFromHtml($html), $filename);
}*/
}
