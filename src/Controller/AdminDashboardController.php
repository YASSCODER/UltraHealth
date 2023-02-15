<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function index(): Response
    {
        return $this->render('admin_dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }

    #[Route('/admin/login', name: 'app_admin_login')]
    public function Login(): Response
    {
        return $this->render('admin_dashboard/login.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }

    #[Route('/admin/register', name: 'app_admin_register')]
    public function Register(): Response
    {
        return $this->render('admin_dashboard/register.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }

    #[Route('/admin/forgetpassword', name: 'app_admin_forgetpassword')]
    public function ForgetPassword(): Response
    {
        return $this->render('admin_dashboard/forgetpassword.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }

    #[Route('/admin/articlePage', name: 'app_admin_articlePage')]
    public function ArticlePage(): Response
    {
        return $this->render('admin_dashboard/aticlePage.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }
    #[Route('/admin/forumPage', name: 'app_admin_forumPage')]
    public function ForumPage(): Response
    {
        return $this->render('admin_dashboard/forumPage.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);
    }
}
