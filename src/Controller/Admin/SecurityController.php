<?php

namespace App\Controller\Admin;

use App\Form\Admin\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'admin_security_')]
class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('admin/security/login.html.twig', [
            'form' => $this->createForm(LoginType::class)->createView(),
        ]);
    }

    #[Route('logout', name: 'logout')]
    public function logout(): void
    {}
}
