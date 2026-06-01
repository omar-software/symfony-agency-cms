<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    // Diese Route zeigt die Startseite unserer kleinen Agentur-Webseite
    #[Route('/', name: 'app_home')]
    public function index(ProjectRepository $projectRepository): Response
    {
        // Hier holen wir nur veröffentlichte Projekte aus der Datenbank
        $projects = $projectRepository->findBy(
            ['isPublished' => true],
            ['createdAt' => 'DESC']
        );

        // Hier senden wir den Seitentitel und die Projekte an das Twig-Template
        return $this->render('home/index.html.twig', [
            'pageTitle' => 'Mini Agency CMS',
            'projects' => $projects,
        ]);
    }
}