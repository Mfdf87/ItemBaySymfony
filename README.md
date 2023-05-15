# ItemBaySymfony

Dans ce projet, nous allons créer un site web de gestion d'items de jeu vidéo.

## Installation
Pour installer le projet symfony sur une machine, voici les différentes étapes à suivre dans l'ordre : 
1. Installer wamp sur windows ou lamp sous linux pour avoir un serveur web avec php version 8.1.16, mysql version 5.7
1. Installer symfony avec [ce lien](https://symfony.com/download)
1. Installer composer avec [ce lient](https://getcomposer.org/)
1. Cloner le dépot Github dans un dossier
1. Effectuer la commande suivante : `composer install` pour installer les dépendances requises par le projet
1. Créer un fichier d'environnement local `.env.dev.local` pour la connexion à la base de données. Dans ce fichier, il faut mettre la ligne suivante : 
`DATABASE_URL="mysql://itembay:itembay@127.0.0.1:3306/itembay?serverVersion=mariadb-10.6.12&charset=utf8mb4"` avec les informations pour se connecter à la base.
1. Effectuer les commandes suivantes pour créer la base de donnée et rentrer les données : 
```
symfony console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate

composer require --dev orm-fixtures
composer require --dev fakerphp/faker

php bin/console doctrine:fixtures:load
```
1. Lancer le serveur avec la commande suivante : `symfony server:start -d`
Pour l'arrêter, il faudra faire la commande `symfony server:stop`
