# STI-Project1

> Auteurs : Muaremi Dejvid - Silvestri Romain  
> Enseignant : Rubinstein Scharf Abraham  
> Assistants : Martini Yohan  
> Date : 29.10.2018  

## Introduction
L'objectif de ce projet est de créer une application web très simple qui permet de gérer une boîte de messagerie ainsi que des utilisateurs.

### Technologies
Pour cette application, nous avons utilisé de l'html et du php ainsi qu'un bootstrap pour un avoir un visuel agéable. L'envoie et la réception de message se fait simplement via une base de donnée SQLite. Une interface phpliteadmin est disponible afin de gérer cette base de donnée.
Docker pour mettre en place le serveur.

## L'application
### Gestion des accès
Pour gérer les accès, nous avons utilisé des sessions. Pour se connecter à une page, une session doit être active. Le type de session (admin ou standard) permet de définir quelles pages sont accessibles et lesquelles ne le sont pas par l'utilisateur courant.  
La seule page ne nécessitant pas de session est celle de login. La session reste active tant que l'utilisateur ne se déconnecte pas.

### Gestion des rôles
La gestion des rôles se fait au travers de la variable de session qui contient le rôle de l'utilisateur actuel.

### Fonctionnalités
Un utilisateur standard a la possibilité de:
  - Changer son mot de passe
  - Accéder à ses mails
  - "Gérer" sa boîte mail (supprimer des messages, voir les détails d'un message et envoyer une réponse)
  - Envoyer un message  

Un administrateur peut:
- Effectuer toutes les actions d'un utilisateur standard
- Voir la liste des utilisateurs
- "Gérer" les utilisateurs (ajout, suppression, modification du compte et changement de mot de passe)

## Démarrage
Notre application se lance grâce à un container docker. Elle nécessite donc d'avoir Docker d'installé sur la machine. Le répertoire "site" du projet doit contenir un sous-répertoire "html" pour les fichiers de l'application et un sous-répertoire "databases" pour les bases de donnés.

Il faut ensuite effectuer les étapes ci-dessous:
- docker run -ti -v "$PWD/site":/usr/share/nginx/ -d -p 8080:80 --name sti_project --hostname sti arubinst/sti:project2018

Vous pouvez changer le port 8080 par un autre port s’il est déjà occupé par un service tournant sur votre machine.

Ensuite, pour lancer les services web et PHP, utiliser les commandes suivantes :

- docker exec -u root sti_project service nginx start  
- docker exec -u root sti_project service php5-fpm start

Ensuite, il faut ouvrir **[la page d'administration de la base de donnée] (http://ip_docker:8080/phpliteadmin.php)** et y importer le dump de notre base de données que vous pouvez trouver sous /site/databases/database_2018-10-17.dump.sql
Celui-ci va créer un administrateur, ainsi qu'un utilisateur par défaut.

Vous pouvez alors vous connecter sur la web app et commencer à envoyer des messages.

Pour arrêter l'application, il suffit de stopper le container.
