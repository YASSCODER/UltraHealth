<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

#[Route('/menu')]
class MenuController extends AbstractController
{
    #[Route('/', name: 'app_menu_index', methods: ['GET'])]
    public function index(MenuRepository $menuRepository): Response
    {
        return $this->render('menu/index.html.twig', [
            'menus' => $menuRepository->findAll(),
        ]);
    }   

    #[Route('/m', name: 'app_menufront_index', methods: ['GET'])]
    public function indexm(MenuRepository $menuRepository): Response
    {
        return $this->render('menu/indexfront.html.twig', [
            'menus' => $menuRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_menu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MenuRepository $menuRepository): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $menuRepository->save($menu, true);

            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('menu/new.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }
    #[Route('/search', name: 'search_menus', methods: ['GET','POST'])]
    public function searchPlats(Request $request, MenuRepository $platRepository)
    {
        $searchQuery = $request->query->get('searchQuery', '');
        
        $menus = $platRepository->searchByTitre($searchQuery);
        
        return $this->render('menu/searchresult.html.twig', [
            'menus' => $menus,
        ]);
    }
    #[Route('/searchadmin', name: 'search_menuadmin', methods: ['GET','POST'])]
    public function searchPlatadmin(Request $request, MenuRepository $platRepository)
    {
        $searchQueryadmin = $request->query->get('searchQueryadmin', '');
        
        $menus = $platRepository->searchByTitre($searchQueryadmin);
        
        return $this->render('menu/searchresultadmin.html.twig', [
            'menus' => $menus,
        ]);
    }
    #[Route('/m/QrCode/{id}', name: 'app_QrCode')]
    public function qrCode(ManagerRegistry $doctrine, $id, MenuRepository $Menu)
    {
        return $this->render("menu/qrcodemenu.html.twig", ['id' => $id]);
    }

    #[Route('/m/QrCode/generate/{id}', name: 'app_qrmenu_codes')]
    public function qrGenerator(ManagerRegistry $doctrine, $id, MenuRepository $Menu)
    {
        $em = $doctrine->getManager();
        $res = $Menu->find($id);
      //  $qrcode = QrCode::create($res->getNom() .  " Et le prix est: " . $res->getPrix())
        $qrcode = QrCode::create( " - Votre fiche Menu est:". $res->getId() )

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

    #[Route('/{id}', name: 'app_menu_show', methods: ['GET'])]
    public function show(Menu $menu): Response
    {
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }
    #[Route('/m/{id}', name: 'app_menufront_show', methods: ['GET'])]
    public function showm(Menu $menu): Response
    {
        return $this->render('menu/showfront.html.twig', [
            'menu' => $menu,
        ]);
    }
    #[Route('/m/{id}/pdf', name: 'app_pdf_menufront_show', methods: ['GET'])]
    public function indexx(Menu $menu)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('menu/menupdf.html.twig', [
            'menu' => $menu,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();
       
        $publicDirectory = $this->getParameter('menu_pdf_directory');

        $pdfFilepath =  $publicDirectory . '/' . uniqid() . '.pdf';

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);
        
        // Send some text response
        return new Response("The PDF file has been succesfully generated !");
    }


    #[Route('/{id}/edit', name: 'app_menu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Menu $menu, MenuRepository $menuRepository): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $menuRepository->save($menu, true);

            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_menu_delete', methods: ['POST'])]
    public function delete(Request $request, Menu $menu, MenuRepository $menuRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->request->get('_token'))) {
            $menuRepository->remove($menu, true);
        }

        return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
    }
}
