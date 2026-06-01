<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Repository\ContactMessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminMessageController extends AbstractController
{
    // Diese Route zeigt alle Kontaktanfragen im Admin-Bereich
    #[Route('/admin/messages', name: 'app_admin_messages')]
    public function index(ContactMessageRepository $contactMessageRepository): Response
    {
        // Hier schützen wir die Seite zusätzlich für Admin-Benutzer
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Hier holen wir alle Kontaktanfragen aus der Datenbank
        $messages = $contactMessageRepository->findBy(
            [],
            ['createdAt' => 'DESC']
        );

        // Hier senden wir die Nachrichten an das Twig-Template
        return $this->render('admin_message/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    // Diese Route markiert eine Kontaktanfrage als gelesen
    #[Route('/admin/messages/{id}/read', name: 'app_admin_message_read')]
    public function markAsRead(
        ContactMessage $contactMessage,
        EntityManagerInterface $entityManager
    ): Response {
        // Hier schützen wir die Seite zusätzlich für Admin-Benutzer
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Hier setzen wir den Status auf gelesen
        $contactMessage->setIsRead(true);

        // Hier speichern wir die Änderung in der Datenbank
        $entityManager->flush();

        // Danach gehen wir zurück zur Nachrichtenliste
        return $this->redirectToRoute('app_admin_messages');
    }
}