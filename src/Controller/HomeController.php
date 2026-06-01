<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    // Diese Route zeigt die Startseite unserer kleinen Agentur-Webseite
    #[Route('/', name: 'app_home')]
    public function index(
        ProjectRepository $projectRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        // Hier holen wir nur veröffentlichte Projekte aus der Datenbank
        $projects = $projectRepository->findBy(
            ['isPublished' => true],
            ['createdAt' => 'DESC']
        );

        // Diese Variable zeigt später eine Erfolgsmeldung im Template
        $messageSaved = $request->query->get('messageSaved') === '1';

        // Wenn das Kontaktformular abgeschickt wurde, speichern wir die Nachricht
        if ($request->isMethod('POST')) {
            $contactMessage = new ContactMessage();

            // Hier lesen wir die Formularwerte aus
            $contactMessage->setName($request->request->get('name'));
            $contactMessage->setEmail($request->request->get('email'));
            $contactMessage->setMessage($request->request->get('message'));

            // Neue Nachrichten sind am Anfang noch nicht gelesen
            $contactMessage->setIsRead(false);

            // Hier setzen wir das Erstellungsdatum
            $contactMessage->setCreatedAt(new \DateTimeImmutable());

            // Hier speichern wir die Nachricht in der Datenbank
            $entityManager->persist($contactMessage);
            $entityManager->flush();

            // Nach einem POST machen wir einen Redirect, damit Turbo zufrieden ist
            return $this->redirectToRoute('app_home', [
                'messageSaved' => '1',
            ]);
        }

        // Hier senden wir den Seitentitel, die Projekte und die Meldung an Twig
        return $this->render('home/index.html.twig', [
            'pageTitle' => 'Mini Agency CMS',
            'projects' => $projects,
            'messageSaved' => $messageSaved,
        ]);
    }
}