<p align="center"><a href="https://univerdog.site" target="_blank"><img src="https://univerdog.site/src/images/logo.png" width="100" alt="UniversDog Logo"></a></p>



# 🐾 UniversDog API

## 📘 À propos du projet

UniversDog est une API RESTful robuste construite avec Laravel, conçue pour révolutionner la gestion des services canins. Notre plateforme offre une solution complète pour l'authentification des utilisateurs, la gestion des rendez-vous et le partage des fiches de chiens et QR codes.

### 🌟 Fonctionnalités principales

-   🔐 [Authentification sécurisée](https://univerdog.site/login)
-   📅 [Gestion avancée des rendez-vous](https://univerdog.site/login)
-   📸 [Partage et gestion de QR codes](https://univerdog.site/login)
-   🤝 [Commentaires de propriétaires de chiens](https://univerdog.site/login)

## 🛠 Spécifications techniques

| Technologie          | Description        |
| -------------------- | ------------------ |
| **Framework**        | Laravel 10.x       |
| **PHP Version**      | 8.1+               |
| **Architecture**     | API RESTful        |
| **Base de données**  | MySQL 8.0          |
| **ORM**              | Eloquent           |
| **Authentification** | Laravel Sanctum    |
| **Validation**       | Form Requests      |
| **Stockage**         | Laravel Filesystem |
| **Tests**            | PHPUnit            |

## 🔒 Sécurité

-   Authentification via tokens Sanctum
-   Validation stricte des entrées avec Form Requests
-   Politiques d'autorisation pour chaque action
-   Stockage sécurisé des mots de passe avec Bcrypt
-   Protection CSRF pour les routes web


## 💻 Composants principaux

-   **Controllers** : Gèrent les requêtes entrantes et génèrent les réponses.
-   **Models** : Interagissent avec la base de données.
-   **Services** : Logiques métier.
-   **Requests** : Valider les données des requêtes.
-   **Resources** : Formater les réponses.
-   **Migrations** : Gérer la structure de la base de données.
-   **Routes** : Gérer les routes de l'API.

### 🔑 AuthController

Le `AuthController` est responsable de l'authentification des utilisateurs. Il gère les routes pour l'inscription, la connexion, la déconnexion et la récupération du profil utilisateur.

#### 📄 Routes

-   `POST /api/register` : Inscrire un nouvel utilisateur.
-   `POST /api/login` : Connecter un utilisateur existant.
-   `POST /api/logout` : Déconnecter un utilisateur.

### 📅 AppointmentController

Le `AppointmentController` est responsable de la gestion des rendez-vous. Il gère les routes pour la création, la récupération, la mise à jour et la suppression des rendez-vous.

#### 📄 Routes

-   `POST /api/appointments` : Créer un nouveau rendez-vous.
-   `GET /api/appointments/{id}` : Récupérer un rendez-vous par ID.
-   `PUT /api/appointments/{id}` : Mettre à jour un rendez-vous existant.
-   `DELETE /api/appointments/{id}` : Supprimer un rendez-vous.

### 📸 PhotoController

Le `PhotoController` est responsable de la gestion des photos de chiens. Il gère les routes pour la création, la récupération, la mise à jour et la suppression des photos.

#### 📄 Routes

-   `POST /api/photos` : Créer une nouvelle photo.
-   `GET /api/photos/{id}` : Récupérer une photo par ID.
-   `PUT /api/photos/{id}` : Mettre à jour une photo existante.

## 🚀 Installation

1. Clonez le dépôt :
    ```bash
    git clone https://github.com/ACHGAR2024/Univerdog.site.backend.git
    cd univerdog-api
    ```
2. Installez les dépendances :
    ```bash
    composer install
    ```
3. Configurez l'environnement :
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4. Configurez la base de données dans `.env`
5. Exécutez les migrations :
    ```bash
    php artisan migrate
    ```
6. Lancez le serveur :
    ```bash
    php artisan serve
    ```

## 📚 Documentation API

Consultez notre [documentation API complète](https://api.univerdog.site) pour des informations détaillées sur tous les points d'entrée disponibles.

## 🤝 Contribution

Nous accueillons chaleureusement les contributions ! Consultez notre [guide de contribution](https://univerdog.site/contact) pour commencer.

## 📄 Licence

UniversDog est un code open-source.

---

<p align="center">Fait avec ❤️ par le projet UniversDog</p>
