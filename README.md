OnBoarding modalité d’installation :

Ouvrir le fichier zip

Installer docker-compose
Lancer la commande suivante à la racine du projet : docker-compose up —build

Dans le ficher hosts du pc, ajouter les ligne suivante :
127.0.0.1 admin.test-symfony.vlabs

URL du login :
http://admin.test-symfony.vlabs/login

Identifiant super admin :
sa@sa.sa
Mot de passe super admin :
Sa

Créer la database :
symfony

Y Insérer le fichier database.sql du dossier database à la racine du projet

Dans le fichier .env, modifier le contenu selon la database installée.
Par défaut :
DATABASE_URL="mysql://root:root@mariadb:3306/symfony?serverVersion=mariadb-10.3.40charset=utf8"
