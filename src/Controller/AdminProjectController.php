<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    // Diese Route zeigt das Formular zum Erstellen eines neuen Projekts
    #[Route('/admin/projects/new', name: 'app_admin_project_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Hier schützen wir die Seite zusätzlich für Admin-Benutzer
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Wenn das Formular abgeschickt wurde, speichern wir das neue Projekt
        if ($request->isMethod('POST')) {
            $project = new Project();

            // Hier lesen wir die Formularwerte aus
            $project->setTitle($request->request->get('title'));
            $project->setDescription($request->request->get('description'));
            $project->setTechnology($request->request->get('technology'));

            // Checkbox: Wenn sie angeklickt ist, kommt ein Wert zurück
            $isPublished = $request->request->get('isPublished') ? true : false;
            $project->setIsPublished($isPublished);

            // Bild-Upload machen wir später, deshalb bleibt imageName erstmal leer
            $project->setImageName(null);

            // Hier setzen wir das Erstellungsdatum
            $project->setCreatedAt(new \DateTimeImmutable());

            // Hier speichern wir das Projekt in der Datenbank
            $entityManager->persist($project);
            $entityManager->flush();

            // Danach gehen wir zurück zur Projektliste
            return $this->redirectToRoute('app_admin_projects');
        }

        // Wenn es kein POST ist, zeigen wir nur das Formular
        return $this->render('admin_project/new.html.twig');
    }

    // Diese Route zeigt das Formular zum Bearbeiten eines Projekts
#[Route('/admin/projects/{id}/edit', name: 'app_admin_project_edit')]
public function edit(Project $project, Request $request, EntityManagerInterface $entityManager): Response
{
    // Hier schützen wir die Seite zusätzlich für Admin-Benutzer
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    // Wenn das Formular abgeschickt wurde, aktualisieren wir das Projekt
    if ($request->isMethod('POST')) {
        // Hier lesen wir die neuen Formularwerte aus
        $project->setTitle($request->request->get('title'));
        $project->setDescription($request->request->get('description'));
        $project->setTechnology($request->request->get('technology'));

        // Checkbox: Wenn sie angeklickt ist, kommt ein Wert zurück
        $isPublished = $request->request->get('isPublished') ? true : false;
        $project->setIsPublished($isPublished);

        // Hier speichern wir die Änderungen in der Datenbank
        $entityManager->flush();

        // Danach gehen wir zurück zur Projektliste
        return $this->redirectToRoute('app_admin_projects');
    }

    // Wenn es kein POST ist, zeigen wir das Formular mit den aktuellen Daten
    return $this->render('admin_project/edit.html.twig', [
        'project' => $project,
    ]);
}
}