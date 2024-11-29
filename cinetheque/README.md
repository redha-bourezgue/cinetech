# Cinetech 🎥

Cinetech est une application web de gestion de films, permettant aux utilisateurs de consulter des films, de les ajouter à une liste de favoris ou de les marquer comme à voir. Ce projet utilise l'API TMDB pour récupérer les informations sur les films. 🎬

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les outils suivants :

- [PHP](https://www.php.net/) (version 7.4 ou supérieure) 💻
- [Composer](https://getcomposer.org/) 🎶
- [MySQL](https://www.mysql.com/) 🚀
- [Node.js](https://nodejs.org/) (pour les dépendances front-end) 🚀
- [Git](https://git-scm.com/) 🚀

## Installation

1. Clonez le dépôt :

   ```bash
   git clone https://github.com/redha_bourezgue/cinetech.git
   cd cinetech
   ```

2. Installez les dépendances PHP avec Composer :

   ```bash
   composer install
   ```

3. Installez les dépendances front-end avec npm :

   ```bash
   npm install
   ```

## Configuration

1. Créez un fichier `.env` à la racine du projet et configurez les variables suivantes :

   ```plaintext
   DB_HOST=localhost
   DB_NAME=cinetheque
   DB_USER=root
   DB_PASS=
   ```

   

2. Créez la base de données et les tables nécessaires en exécutant le script `setup.php` :

   ```bash
   php database/setup.php
   ```




## Fonctionnalités

- Consultation des films à l'affiche et à venir 🎥.
- Ajout de films à une liste de favoris ❤️.
- Marquer des films comme à voir 🎬.
- Système de notation des films 🌟.
- Historique de visionnage 📚.

## Déploiement sur GitHub

1. Créez un nouveau dépôt sur GitHub.
2. Ajoutez le dépôt distant :

   ```bash
   git remote add origin https://github.com/redha-bourezgue /cinetech.git
   ```

3. Poussez votre code :

   ```bash
   git add .
   git commit -m "Initial commit"
   git push -u origin master
   ```

## Contribuer

Les contributions sont les bienvenues ! Veuillez soumettre une demande de tirage (pull request) pour toute amélioration ou correction. 🚀

## Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails. 📜
