OnBoarding modalité d’installation :

Installer docker-compose
Lancer la commande suivante à la racine du projet : docker-compose up —build

Installer yarn et composer sur son poste :

Lancer la commande suivante pour accéder au container php :
./runner php dev
Si la commande ne fonctionne pas, essayer : 
sh php dev
Ou : 
bash php dev

Lancer ensuite la commande, dans le container php : 
composer install
Pour finir, quitter le container avec : 
exit 

Lancer la commande suivante dans le dossier symfony, pour installer les dépendances :
yarn install 

Ensuite, lancer la commande : 
yarn encore dev

Dans le ficher hosts du pc, ajouter les ligne suivante :
127.0.0.1 	admin.test-symfony.vlabs

Pour la partie base de donnée, étant donné que le serveur est un mariadb sur le docker.
Utiliser de préférence phpstorm, avec la fenètre database intégrée.
Quand les box docker sont actives :
Sur la fenètre db de php storm, ajouter mariadb, la connexion se fera toute seule.
Ensuite, il faut ajouter la db "symfony" et y insérer le script database.sql
à la racine du projet.

Dans le fichier .env, modifier le contenu selon la database installée (si différent).
Normalement, c'est le bon code. 
Par défaut :
DATABASE_URL="mysql://root:root@mariadb:3306/symfony?serverVersion=mariadb-10.3.40charset=utf8"

Identifiant super admin :
sa@sa.sa
Mot de passe super admin :
Sa

URL du login :
http://admin.test-symfony.vlabs/login