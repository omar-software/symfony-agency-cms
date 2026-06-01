<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    // Diese Route zeigt das Admin-Dashboard
    #[Route('/admin', name: 'app_admin')]
    public function index(ProjectRepository $projectRepository): Response
    {
        // Hier schützen wir die Seite zusätzlich im Controller
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Hier zählen wir alle Projekte aus der Datenbank
        $projectCount = $projectRepository->count([]);

        // Hier zählen wir nur veröffentlichte Projekte
        $publishedProjectCount = $projectRepository->count([
            'isPublished' => true,
        ]);

        // Hier senden wir die Zahlen an das Twig-Template
        return $this->render('admin/index.html.twig', [
            'projectCount' => $projectCount,
            'publishedProjectCount' => $publishedProjectCount,
        ]);
    }
}