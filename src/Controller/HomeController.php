<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    // Diese Route zeigt die Startseite unserer kleinen Agentur-Webseite
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Hier senden wir einfache Daten an das Twig-Template
        return $this->render('home/index.html.twig', [
            'pageTitle' => 'Mini Agency CMS',
        ]);
    }
}