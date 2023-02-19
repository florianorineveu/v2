<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'admin_dashboard')]
    public function __invoke()
    {
        return $this->render('admin/dashboard/index.html.twig', []);
    }
}