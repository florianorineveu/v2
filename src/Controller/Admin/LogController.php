<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LogController extends AbstractController
{
    public function index()
    {
        return $this->render('admin/log/index.html.twig', [
        ]);
    }
}
