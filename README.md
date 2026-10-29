# Espace du conseil municipal

Application Laravel 12 pour la gestion du conseil municipal.

## Configuration requise

- PHP >= 8.2
- MySQL >= 8.0
- Composer
- Node.js (optionnel pour Vite)

## Installation

1. Cloner le dépôt
2. Installer les dépendances : `composer install`
3. Configurer l'environnement : `cp .env.example .env`
4. Configurer la base de données dans `.env` :
   ```
   DB_DATABASE=conseil_municipal
   DB_USERNAME=votre_utilisateur
   DB_PASSWORD=votre_mot_de_passe
   ```
5. Configurer l'administrateur dans `.env` :
   ```
   ADMIN_EMAIL=admin@example.com
   ADMIN_PASSWORD=mot_de_passe
   ```
6. Exécuter les migrations : `php artisan migrate`
7. Exécuter les seeders : `php artisan db:seed`
8. Générer la clé d'application : `php artisan key:generate`
9. Lancer le serveur : `php artisan serve`

## Structure de l'application

### Modèles
- **User** : Utilisateurs avec rôles (admin, conseiller) et statuts (en_attente, valide, suspendu)
- **SessionTravail** : Sessions du conseil
- **SessionDocument** : Documents associés aux sessions
- **Deliberation** : Délibérations du conseil
- **PlanPai** : Plans d'investissement
- **Budget** : Budgets annuels
- **Besoin** : Besoins prioritaires par canton
- **Canton** : Cantons de la commune
- **DocumentAdministration** : Documents administratifs
- **MembreBureau** : Membres du bureau
- **JournalActivite** : Journal d'activité

### Rôles et permissions
- **Administrateur** : Accès complet, gestion des comptes, journal, paramètres
- **Conseiller** : Accès en lecture, création de besoins

### Modules
- Sessions de travail
- Plans d'investissement (PAI)
- Budgets
- Besoins prioritaires
- Délibérations
- Administration
- Gestion des comptes (admin)
- Journal d'activité (admin)
- Paramètres (admin)

## Configuration

### Fichiers autorisés
- PDF : `.pdf` (max 10 Mo pour documents de session, 20 Mo pour PAI/Budgets)
- Images : `.jpg`, `.jpeg`, `.png`, `.webp` (max 2 Mo pour photos)

### Stockage
Les fichiers sont stockés dans `storage/app/private` (disque local).

## Routes principales

- `/dashboard` : Tableau de bord
- `/sessions` : Gestion des sessions
- `/pai` : Plans d'investissement
- `/budgets` : Budgets
- `/besoins` : Besoins prioritaires
- `/deliberations` : Délibérations
- `/administration` : Administration
- `/comptes` : Gestion des comptes (admin)
- `/journal` : Journal d'activité (admin)
- `/parametres` : Paramètres (admin)

## Développement

### Tests
Lancer les tests : `php artisan test`

### Linting
Lancer les tests de statique : `php artisan test --parallel`

## Licence

Ce projet est propriété de la commune.

