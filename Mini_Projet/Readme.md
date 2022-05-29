# Projet Développement Web

![GitHub issues](https://img.shields.io/github/issues/arthurmadecprevost/arthurmadecprevost/mini-projet-devweb?label=issues)

****

Le Projet de Développement Web est un projet en Symfony 4.4 utilisant le squelette [website-skeleton](https://packagist.org/packages/symfony/website-skeleton#v4.4.99).
Il est connecté à une base de données relationnelle MySQL.
****
## Installation
### Symfony
Pour installer le projet, il vous suffit de faire un clone de ce répertoire Git, puis d'exécuter ces commandes :
    
    git clone https://github.com/enoraLD/Mini_projet-master.git
    composer install
Toutes les dépendances sont désormais installées. 

### Base de données
Vous devez configurer le **.env** et en remplaçant les identifiants par ceux de votre base de données. Assurez-vous d'être bien dans le dossier Mini_Projet pour exécuter l'ensemble des ces commandes. 

Par défaut, la variable _APP_ENV_ est en _prod_, vous n'aurez donc pas accès au profiler Symfony (débug). Si vous souhaitez activer le profiler, merci de passer _APP_ENV_ à _dev_.

Une fois les identifiants modifiés et votre .env configuré, vous pouvez créer votre base de données si celle-ci n'existe pas déjà avec la commande :

    php bin/console doctrine:database:create --if-not-exists

Puis vous pouvez **vérifier** que le schema de votre base est bien mappé avec la commande suivante :
    
    php bin/console doctrine:schema:validate
    
Doctrine (qui est une dépendance de notre projet) va alors s'occuper de créer les tables pour vous avec la commande :

    php bin/console doctrine:schema:update --force 

Vous pouvez voir le détail des requêtes SQL avec la commande :

    php bin/console doctrine:schema:update --dump-sql

## Développement
Lors du développement sur le projet, vous aurez peut-être besoin de ces commandes:

Pour mettre à jour le composer.

   composer update


## Déploiement

Pour déployer l'application, nous vous recommandons l'utilisation de PHP 7.4 (version utilisée lors de son développement).

Vous aurez besoin de configurer la base de données comme vu plus haut, puis d'installer les fixtures (données par défaut) avec la commande suivante:

**Attention, la commande s'executera uniquement sur un environnement de développement (APP_ENV sur dev dans le .env)**

Installation des fixtures
```bash
php bin/console doctrine:fixtures:load
```

Une fois tout cela fait, il ne vous reste plus qu'a lancer le serveur interne de php avec la commande :
```bash
  php -S localhost:8000 -t public
```

## Utilisateurs de la DEMO

Après avoir installé les fixtures, vous trouverez ces différents utilisateurs:
``` 
ADMIN:
    username : admin
    password: admin
USERS:
    username: user1
    password: user1
    
    username: user2
    password: user2
