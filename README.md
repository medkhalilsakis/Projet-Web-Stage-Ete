# Démarrage du Projet Booking

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :
- **Node.js** et **npm** (pour le front-end)
- **Composer** (pour le back-end Laravel)
- **XAMPP** ou un autre serveur de base de données MySQL

## Étapes pour Démarrer le Projet

```bash
# 1. Naviguer vers le répertoire du front-end (Vue.js)
cd front-end/booking-plat

# 2. Installer les dépendances du front-end
npm install

# 3. Démarrer le serveur de développement du front-end
npm run serve

# 4. Ouvrir un nouveau terminal et naviguer vers le répertoire du back-end (Laravel)
cd booking-app

# 5. Installer les dépendances du back-end
composer install

# 6. Démarrer le serveur Laravel
php artisan serve
