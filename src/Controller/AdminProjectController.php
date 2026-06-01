<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminProjectController extends AbstractController
{
    // Diese Route zeigt alle Projekte im Admin-Bereich
    #[Route('/admin/projects', name: 'app_admin_projects')]
    public function index(ProjectRepository $projectRepository): Response
    {
        // Hier schützen wir die Seite zusätzlich für Admin-Benutzer
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Hier holen wir alle Projekte aus der Datenbank
        $projects = $projectRepository->findBy(
            [],
            ['createdAt' => 'DESC']
        );

        // Hier senden wir die Projekte an das Twig-Template
        return $this->render('admin_project/index.html.twig', [
            'projects' => $projects,
        ]);
    }
}