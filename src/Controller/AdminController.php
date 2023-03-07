<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
       return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_new', methods: ['GET', 'POST'])]
    public function newAdmin(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $role = ['role' => 'ADMIN'];
        $user->setRole($role);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}


//     #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
//     public function show(User $user): Response
//     {
//         return $this->render('user/show.html.twig', [
//             'user' => $user,
//         ]);
//     }

//     #[Route('/{id}/edit', name: 'app_admin_edit', methods: ['GET', 'POST'])]
//     public function edit(Request $request, User $user, UserRepository $userRepository): Response
//     {
//         $form = $this->createForm(UserType::class, $user);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             $userRepository->save($user, true);

//             return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
//         }

//         return $this->renderForm('admin/edit.html.twig', [
//             'user' => $user,
//             'form' => $form,
//         ]);
//     }

//     #[Route('/{id}', name: 'app_admin_delete', methods: ['POST'])]
//     public function delete(Request $request, User $user, UserRepository $userRepository): Response
//     {
//         if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
//             $userRepository->remove($user, true);
//         }

//         return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
//     }