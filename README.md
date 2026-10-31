# HR Visualization Platform / Plateforme de Visualisation RH

## Sommaire / Table of Contents
- [Français](#français)
  - [À propos](#à-propos)
  - [Fonctionnalités](#fonctionnalités)
  - [Installation](#installation)
  - [Dépendances](#dépendances)
  - [Configuration de l'environnement](#configuration-de-lenvironnement)
  - [Base de données et Seeders](#base-de-données-et-seeders)
  - [Lancer le projet](#lancer-le-projet)
  - [Routes importantes](#routes-importantes)
  - [Screenshots](#screenshots)
- [English](#english)
  - [About](#about)
  - [Features](#features)
  - [Installation](#installation-1)
  - [Dependencies](#dependencies)
  - [Environment Setup](#environment-setup)
  - [Database and Seeders](#database-and-seeders)
  - [Run the Project](#run-the-project)
  - [Important Routes](#important-routes-1)
  - [Screenshots](#screenshots-1)

---

## Français

### À propos
Ce projet est mon projet de **stage de 3ème année** au CESI, dans le cadre de ma formation.  
Il s'agit d'une **plateforme web de visualisation des congés, missions et connexions des employés**.  
Le cœur du projet réside dans l'**analyse des connexions avec un modèle de Machine Learning** pour détecter les comportements suspects via une API externe.

### Fonctionnalités
- Visualisation des congés des employés.
- Visualisation et attribution des missions.
- Analyse des connexions en temps réel avec détection ML.
- Interface sécurisée et intuitive.

### Installation
1. Clonez le projet depuis GitHub :
```bash
git clone https://github.com/WassimT1455/HR-Visualization-Platform.git
cd hr-visualization-platform
```

2. Installer les dépendances PHP :
```bash
composer install
```

3. Installer les dépendances JS :
```bash
npm install
```

### Dépendances
- Laravel 10+
- PHP 8+
- MySQL ou MariaDB
- Node.js & NPM
- Vite (pour le build frontend)
- FontAwesome & Google Fonts

### Configuration de l'environnement
1. Copier le fichier `.env.example` en `.env` :
```bash
cp .env.example .env
```

2. Configurer la connexion à la base de données dans `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hr_platform
DB_USERNAME=root
DB_PASSWORD=
```

3. Générer la clé de l'application :
```bash
php artisan key:generate
```

### Base de données et Seeders
Pour une première utilisation, le projet inclut des seeders pour créer des utilisateurs test et des congés/missions :
```bash
php artisan migrate
php artisan db:seed
```

### Lancer le projet
1. Lancer le serveur PHP :
```bash
php artisan serve
```

2. Lancer Vite pour le frontend :
```bash
npm run dev
```

Le site sera accessible sur [http://127.0.0.1:8000](http://127.0.0.1:8000)

### Routes importantes
- Page de login : `/login`
- Dashboard admin : `/admin` (accessible uniquement aux administrateurs)
- Création d’un utilisateur : `/register` (accessible uniquement aux administrateurs)
- Page de prédiction ML : `/prediction` (analyse des connexions)

### Screenshots
<img width="1919" height="862" alt="image" src="https://github.com/user-attachments/assets/0861e062-e1e5-4eb4-aaa7-12b649cf48fc" />
<img width="1896" height="864" alt="image" src="https://github.com/user-attachments/assets/58eebf99-bc65-4e72-92ec-e5660cc9ee04" />


---

## English

### About
This project is my **3rd-year internship project** at CESI, part of my studies in development and artificial intelligence.  
It is a **web platform for visualizing employee leaves, missions, and connections**.  
The main focus is on connection analysis with a Machine Learning model to detect suspicious activity via an external API.

### Features
- View employee leave data.
- Assign and view missions.
- Real-time connection analysis with ML detection.
- Secure and intuitive interface.

### Installation
1. Clone the repository:
```bash
git clone https://github.com/WassimT1455/HR-Visualization-Platform.git
cd hr-visualization-platform
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JS dependencies:
```bash
npm install
```

### Dependencies
- Laravel 10+
- PHP 8+
- MySQL or MariaDB
- Node.js & NPM
- Vite (for frontend build)
- FontAwesome & Google Fonts

### Environment Setup
1. Copy `.env.example` to `.env`:
```bash
cp .env.example .env
```

2. Configure database connection in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hr_platform
DB_USERNAME=root
DB_PASSWORD=
```

3. Generate application key:
```bash
php artisan key:generate
```

### Database and Seeders
Seeders are included for first-time use to create test users, leaves, and missions:
```bash
php artisan migrate
php artisan db:seed
```

### Run the Project
1. Start PHP server:
```bash
php artisan serve
```

2. Start Vite for frontend:
```bash
npm run dev
```

The site will be accessible at [http://127.0.0.1:8000](http://127.0.0.1:8000)

### Important Routes
- Login page: `/login`
- Admin dashboard: `/admin` (admin only)
- Create user: `/register` (admin only)
- ML prediction page: `/prediction` (connection analysis)

### Screenshots
<img width="1919" height="862" alt="image" src="https://github.com/user-attachments/assets/0861e062-e1e5-4eb4-aaa7-12b649cf48fc" />
<img width="1896" height="864" alt="image" src="https://github.com/user-attachments/assets/58eebf99-bc65-4e72-92ec-e5660cc9ee04" />
