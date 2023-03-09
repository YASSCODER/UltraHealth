<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleuserController extends AbstractController
{
    #[Route('/roleuser', name: 'app_roleuser')]
    public function index(): Response
    {
        return $this->render('roleuser/index.html.twig', [
            'controller_name' => 'RoleuserController',
        ]);
    }
}
