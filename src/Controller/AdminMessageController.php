<?php

namespace App\Controller;

use App\Repository\ContactMessageRepository;
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
}