# Mini Agency CMS – Symfony Webprojekt

Ein kleines CMS-Webprojekt für eine Internetagentur.  
Das Projekt wurde mit Symfony, PHP, Twig und MySQL umgesetzt und zeigt typische Funktionen einer Agentur-Webseite mit geschütztem Admin-Bereich.

## Ziel des Projekts

Das Projekt dient als praxisnahes Symfony-Webprojekt für die Verwaltung von Referenzprojekten und Kontaktanfragen.  
Es zeigt grundlegende Backend- und Frontend-Funktionen, wie sie in Webprojekten einer Internetagentur vorkommen können.

## Features

- Öffentliche Startseite mit Leistungen, Referenzen und Kontaktformular
- Dynamische Referenzprojekte aus der MySQL-Datenbank
- Kontaktformular mit Speicherung der Nachrichten in MySQL
- Geschützter Admin-Login mit Symfony Security
- Datenbankbasierte Benutzerverwaltung
- Passwort-Hashing für Admin-Benutzer
- Admin-Dashboard mit Projekt- und Nachrichtenstatistiken
- CRUD-Funktionen für Projekte
- Verwaltung von Kontaktanfragen im Admin-Bereich
- Nachrichtenstatus: neu / gelesen
- Responsive Grundstruktur mit HTML und CSS

## Technologien

- PHP
- Symfony 7
- Twig
- Doctrine ORM
- MySQL / MariaDB
- HTML
- CSS
- Composer
- Symfony CLI
- Git / GitHub
- XAMPP für lokale Entwicklung

## Projektstruktur

```text
src/
  Controller/
    HomeController.php
    AdminController.php
    AdminProjectController.php
    AdminMessageController.php
    SecurityController.php

  Entity/
    Project.php
    ContactMessage.php
    User.php

  Repository/
    ProjectRepository.php
    ContactMessageRepository.php
    UserRepository.php

templates/
  home/
  admin/
  admin_project/
  admin_message/
  security/

assets/
  styles/
    app.css
```

## Datenbank-Tabellen

Das Projekt verwendet unter anderem folgende Tabellen:

- `project`
- `contact_message`
- `user`
- `doctrine_migration_versions`

## Lokale Installation

### 1. Repository klonen

```bash
git clone https://github.com/omar-software/symfony-agency-cms.git
cd symfony-agency-cms
```

### 2. Abhängigkeiten installieren

```bash
composer install
```

### 3. Datenbank konfigurieren

In der Datei `.env` die Datenbankverbindung lokal anpassen:

```env
DATABASE_URL="mysql://root:@127.0.0.1:3306/symfony_agency_cms?serverVersion=mariadb-10.4.32&charset=utf8mb4"
```

### 4. Datenbank erstellen

```bash
php bin/console doctrine:database:create
```

### 5. Migrationen ausführen

```bash
php bin/console doctrine:migrations:migrate
```

### 6. Lokalen Server starten

```bash
symfony server:start --no-tls
```

Danach ist die Anwendung erreichbar unter:

```text
http://127.0.0.1:8000
```

## Admin-Bereich

Der geschützte Admin-Bereich ist erreichbar unter:

```text
http://127.0.0.1:8000/admin
```

### Lokaler Test-Admin

Für lokale Tests kann ein Admin-Benutzer in der Datenbank angelegt werden.  
Das Passwort muss vorher mit Symfony gehasht werden:

```bash
php bin/console security:hash-password
```

Beispiel-SQL:

```sql
INSERT INTO `user` (`email`, `roles`, `password`)
VALUES (
    'admin@example.com',
    '["ROLE_ADMIN"]',
    'HASH_HERE'
);
```

## Wichtige Routen

```text
/                       Öffentliche Startseite
/login                  Admin Login
/logout                 Logout
/admin                  Admin Dashboard
/admin/projects         Projektverwaltung
/admin/projects/new     Neues Projekt erstellen
/admin/messages         Kontaktanfragen anzeigen
```

## Beispiel-Funktionen im Admin-Bereich

### Projekte

- Projekte anzeigen
- Neues Projekt erstellen
- Projekt bearbeiten
- Projekt löschen
- Veröffentlichungsstatus verwalten

### Kontaktanfragen

- Kontaktanfragen anzeigen
- Neue Nachrichten erkennen
- Nachricht als gelesen markieren
- Dashboard-Statistiken aktualisieren

## Lernpunkte

In diesem Projekt wurden unter anderem folgende Themen umgesetzt:

- Symfony Routing mit Attributen
- Controller und Twig Templates
- Doctrine Entities und Repositories
- Migrationen mit Doctrine Migrations
- MySQL-Datenbankanbindung
- Formularverarbeitung mit Request-Daten
- Login-System mit Symfony Security
- Rollenbasierter Zugriff mit `ROLE_ADMIN`
- Passwort-Hashing
- Einfache Admin-Oberfläche
- Git-Versionierung mit sinnvollen Commits

## Screenshots

Screenshots können später ergänzt werden:

```text
docs/screenshots/homepage.png
docs/screenshots/admin-dashboard.png
docs/screenshots/project-management.png
docs/screenshots/contact-messages.png
```

## Hinweis

Dieses Projekt ist ein Lern- und Bewerbungsprojekt.  
Der Code ist bewusst einfach und gut nachvollziehbar aufgebaut.

## Lizenz

Dieses Projekt steht unter der MIT-Lizenz.