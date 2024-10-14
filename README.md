<p align="center">
  <a href="https://univerdog.site" target="_blank">
    <img src="https://univerdog.site/src/images/logo.png" width="150" alt="UniversDog Logo">
  </a>
</p>

<h1 align="center">🐾 UniversDog API - Backend</h1>

<p align="center">
  <strong>Une application API RESTful moderne pour les amoureux des chiens</strong>
</p>

<p align="center">
  <a href="#-à-propos">À propos</a> •
  <a href="#-fonctionnalités">Fonctionnalités</a> •
  <a href="#-spécifications-techniques">Spécifications</a> •
  <a href="#-installation">Installation</a> •
  <a href="#-documentation-api">Documentation</a> •
  <a href="#-contribution">Contribution</a> •
  <a href="#-licence">Licence</a>
</p>

<hr>

## 📘 À propos du projet

UniversDog est une API RESTful robuste construite avec Laravel, conçue pour révolutionner la gestion des services canins. Notre plateforme offre une solution complète pour l'authentification des utilisateurs, la gestion des rendez-vous et le partage des fiches de chiens et QR codes.

## 🌟 Fonctionnalités

-   🔐 [Authentification sécurisée](https://univerdog.site/login)
-   📅 [Gestion avancée des rendez-vous](https://univerdog.site/login)
-   📸 [Partage et gestion de QR codes](https://univerdog.site/login)
-   🤝 [Commentaires de propriétaires de chiens](https://univerdog.site/login)
-   🔒 **Authentification JWT** : Utilisation de tokens JWT pour l'authentification sécurisée via le protocole Bearer
-   🔐 **Connexion sécurisée avec Google** : Utilisez Google pour vous connecter de manière sécurisée

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

-   **Controllers** : Gèrent les requêtes entrantes et génèrent les réponses
-   **Models** : Interagissent avec la base de données
-   **Services** : Logiques métier
-   **Requests** : Valident les données des requêtes
-   **Resources** : Formatent les réponses
-   **Seeders** : Gèrent les données de test
-   **Migrations** : Gèrent la structure de la base de données
-   **Routes** : Gèrent les routes de l'API

### Contrôleurs principaux

#### 🔑 AuthController

Responsable de l'authentification des utilisateurs.

**Routes :**

-   `POST /api/register` : Inscrire un nouvel utilisateur
-   `POST /api/login` : Connecter un utilisateur existant
-   `POST /api/logout` : Déconnecter un utilisateur

#### 📅 AppointmentController

Gère les rendez-vous.

**Routes :**

-   `POST /api/appointments` : Créer un nouveau rendez-vous
-   `GET /api/appointments/{id}` : Récupérer un rendez-vous par ID
-   `PUT /api/appointments/{id}` : Mettre à jour un rendez-vous existant
-   `DELETE /api/appointments/{id}` : Supprimer un rendez-vous

#### 📸 PhotoController

Gère les photos de chiens.

**Routes :**

-   `POST /api/photos` : Créer une nouvelle photo
-   `GET /api/photos/{id}` : Récupérer une photo par ID
-   `PUT /api/photos/{id}` : Mettre à jour une photo existante

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

## 🛠 Outils de développement

### 🔄 Exportation des routes vers Postman

Pour faciliter le test et la documentation de l'API, nous avons créé une commande personnalisée qui exporte toutes les routes API vers une collection Postman.

#### Utilisation :

1. Exécutez la commande suivante dans le terminal :

    ```bash
    php artisan export:postman-routes
    ```

2. Un fichier `postman_collection.json` sera généré à la racine du projet.

3. Importez ce fichier dans Postman pour avoir accès à toutes les routes de l'API, organisées par contrôleur.

Cette fonctionnalité permet de :

-   Gagner du temps lors de la configuration de Postman pour les tests d'API
-   Assurer que toutes les routes sont correctement documentées et testables
-   Faciliter la collaboration en partageant facilement la collection Postman à jour

#### Fonctionnement :

La commande parcourt toutes les routes de l'application, filtre celles commençant par `api/`, et les organise dans une structure compatible avec Postman. Les routes sont regroupées par contrôleur pour une meilleure organisation.

Pour plus de détails, consultez le fichier `app/Console/Commands/ExportRoutesToPostman.php`.

## 📚 Documentation API

Consultez notre [documentation API complète](https://api.univerdog.site) pour des informations détaillées sur tous les points d'entrée disponibles.

## 🤝 Contribution

Nous accueillons chaleureusement les contributions ! Consultez notre [guide de contribution](https://univerdog.site/contact) pour commencer.

## 📄 Licence

UniversDog est un code open-source.

---

<p align="center">Fait avec ❤️ par le projet UniversDog</p>
