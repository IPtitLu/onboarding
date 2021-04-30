<p align="center">
  <a href="http://v-labs.fr/">
    <img src="http://www.v-labs.fr/wp-content/themes/vlabs/dist/assets/img/logo_vlabs.svg" alt="Logo V-labs" width="177.976" height="42.739">
  </a>

  <h3 align="center">Test pré-entretien - Symfony</h3>

  <p align="center">
    Ce projet est utilisé dans le cadre d'une évaluation des compétences en Symfony avant de fixer un entretien.
  </p>
</p>

----

<p align="center">
    <strong><a href="mailto:valentin@v-labs.fr?cc=quentin@v-labs.fr&subject=Question concernant le test pré-entretien en Symfony&body=Bonjour,%0AJ'ai une question concernant le test pré-entretien en Symfony :%0A{Votre question}">J'ai une question</a></strong>
    •
    <strong><a href="mailto:valentin@v-labs.fr?cc=quentin@v-labs.fr&subject=Problème concernant le test pré-entretien en Symfony&body=Bonjour,%0AJ'ai rencontré un problème lors du test pré-entretien en Symfony :%0A{Votre problème}">Remonter un problème</a></strong>
    •
    <strong><a href="mailto:valentin@v-labs.fr?cc=quentin@v-labs.fr&subject=Envoi du test pré-entretien en Symfony pour vérification&body=Bonjour,%0AVous trouverez en pièce jointe l'export de la base de données SQL. Voici le lien vers le repository du projet : {Votre repository}">Envoyer votre projet pour vérification</a></strong>
</p>

----

<p align="center">
  <h4 align="center">:exclamation: Note importante :exclamation:</h4>

  <p align="center">
    Veuillez <strong>lire l'ensemble des informations avant de commencer le projet</strong> et les <strong>relire avant d'envoyer pour validation</strong>, pour éviter tout oubli dans le livrable concernant les points obligatoires. Dans le cas où vous voudriez réalisez certains des bonus listés, il se pourrait que votre conception soit altérée et vous oblige une refonte du code qui aurait pu être évitée si considérée dès le départ.
  </p>
</p>

## :bookmark_tabs: &nbsp;Sommaire

+ :vertical_traffic_light: &nbsp;[Pour commencer](#-light-pour-commencer)
  - :book: &nbsp;[Présentation du projet](#-présentation-du-projet)
  - :package: &nbsp;[Prérequis](#-prérequis)
  - :gear: &nbsp;[Installation](#-installation)
+ :notebook_with_decorative_cover: &nbsp;[Cahier des charges](#notebook_with_decorative_cover-cahier-des-charges)
  - :hourglass_flowing_sand: &nbsp;[Délai](#-sand-délai)
  - :outbox_tray: &nbsp;[Ressources à rendre](#outbox_tray-ressources-à-rendre)
  - :inbox_tray: &nbsp;[Ressources nécessaires au développement](#inbox_tray-ressources-nécessaires-au-développement)
  - :mag: &nbsp;[Description technique](#description-technique)
  - :dart: &nbsp;[Objectifs à atteindre](#objectifs-à-atteindre)
  - :warning: &nbsp;[Conditions à remplir](#-conditions-à-remplir)
  - :heavy_check_mark: &nbsp;[Bonus pouvant être réalisés](#-bonus-pouvant-être-réalisés)
+ :thumbsup: &nbsp;[Créateur](#-créateur)


## :vertical_traffic_light: &nbsp;Pour commencer

### :book: &nbsp;Présentation du projet

Dans le cadre de cet exercice, un client vous a contacté pour réaliser un outil lui permettant de gérer son réseau de concessions automobiles, ses employés, ses clients et leurs voitures. Il vous demande donc de pouvoir **se connecter à une administration**, **lister, rechercher, ajouter, supprimer, modifier ou voir le détail des concessions, des modèles de véhicules ainsi que des utilisateurs et leurs véhicules**, **exposer et mettre à jour des données via une API**, le tout, en ayant **un résultat visuel clair et permettant aux utilisateurs de l'outil de facilement trouver ce dont ils ont besoin**. 

### :package: &nbsp;Prérequis

- Téléchargez le binaire `symfony` via l'[installer de Symfony](https://symfony.com/download).
- Installez et utilisez [Docker Compose](https://docs.docker.com/compose/) si possible, sinon simplement [Docker](https://www.docker.com/get-started/) sans passer par Docker Compose. La configuration de Docker et Docker Compose est déjà faite dans le projet à fork. Dans le cas où l'utilisation de Docker n'est pas possible (problème d'OS par exemple), précisez le en haut du `README.md`, ainsi que votre méthode pour lancer le projet en local.

### :gear: &nbsp;Installation

- Fork le repository puis le cloner.
- Faire une copie du fichier `docker-compose.yml.dist` et la nommer `docker-compose.yml`. 
- Aller dans le dossier racine `test-symfony` puis lancer la commande `docker-compose up --build`.
- Effectuer l'installation de la [dernière version LTS de Symfony](https://symfony.com/releases/) dans le dossier `test-symfony/symfony`.
- Voici les configurations à utiliser :
  + Utilisateur super admin à créer :
    * Email : `admin@v-labs.fr`
    * Mot de passe : `vlabs`
  + Base de données :
    * Nom : `symfony`
    * Utilisateur : `root`
    * Mot de passe : `root`
    * Hôte : `mariadb`
  + URL de l'administration : `http://admin.test-symfony.vlabs` (dans le cas de l'utilisation de la configuration Docker Compose, sinon, précisez en haut du `README.md`). Par défaut, l'accès est `http://test-symfony.vlabs`, il faudra donc créer un [host](https://symfony.com/doc/current/routing.html#sub-domain-routing) pour gérer le sous-domaine, sa valeur provenant du fichier `.env` et pouvant être appliqué à un [groupe de routes](https://symfony.com/doc/current/routing.html#routing-route-groups).
  + URL de l'API : `http://api.test-symfony.vlabs` (même cas que l'administration)
  + Documentation API (sécurisée par un [Memory User Provider](https://symfony.com/doc/current/security/user_provider.html#memory-user-provider)) :
    * URL : `http://api.test-symfony.vlabs/api-doc`
    * Login : `admin`
    * Mot de passe : `vlabs`
    
Votre projet devrait donc avoir cette structure :

```text
test-symfony/
├── docker/
│   ├── nginx/
│   ├── mariadb/
│   └── php/
├── symfony/
│   ├── src/
│   └── ...
├── .gitignore
├── docker-compose.yml
├── docker-compose.yml.dist
└── runner
```

## :notebook_with_decorative_cover: &nbsp;Cahier des charges

### :hourglass_flowing_sand: &nbsp;Délai

Il n'y a pas de délai imposé pour la réalisation du projet car les conditions et le temps libre de chacun sont différents, vous pouvez donc le rendre dès que le résultat vous satisfait. Les bonus cités plus bas ne sont pas obligatoires à la validation du projet. Même s'il n'y a aucun délai imposé, il est toujours intéressant de connaître le temps passé sur un projet. Il permet seulement de mieux comprendre votre profil pour adapter l'enseignement nécessaire par la suite et n'est aucunement éliminatoire.

**Temps passé :** {Votre temps passé}

### :outbox_tray: &nbsp;Ressources à rendre

- Repository GitHub (Fork du projet).
- Export SQL de la base de données.
- Liste des accès utilisateurs pour tester les différentes permissions (1 utilisateur par rôle).
- `README.md` mis à jour avec les informations demandées.

### :inbox_tray: &nbsp;Ressources nécessaires au développement

- (A VENIR) Lien vers les maquettes Adobe XD de l'interface d'administration.
- (A VENIR) Zip des assets.

### :mag: &nbsp;Description technique

Vous devrez réaliser une administration Symfony **sécurisée par une connexion préalable avec un [Guard Authenticator](https://symfony.com/doc/current/security.html#guard-authenticators)** et une **API REST avec [FOSRestBundle](https://packagist.org/packages/friendsofsymfony/rest-bundle) et documentée avec [NelmioApiDocBundle](https://packagist.org/packages/nelmio/api-doc-bundle)**. Le rendu visuel devra **se rapprocher au maximum des maquettes données**. Les données affichées sur les pages doivent provenir de la base de données, il ne s'agit **pas de données statiques**. La **navigation** entre les différentes pages doit être **fonctionnelle**. Les formulaires doivent avoir des **validations côté serveur**. Chaque action devra avoir les **bons droits d'accès** [définis dans le Controller](https://symfony.com/doc/current/security.html#security-securing-controller) et **l'affichage devra évoluer selon le rôle de l'utilisateur connecté**.

Voici la **liste non exhaustive des entités** (vous pourriez en avoir besoin d'autre pour répondre à une utilisation fonctionnelle, des bonus ou des ajouts spontanés) :
- `concession` : Peut avoir un ou plusieurs `user`, qui sont les employés de la concession.
- `user` : Peut être rattaché à une `concession` s'il s'agit d'un employé. Peut avoir un ou plusieurs `vehicle`.
- `vehicle_model` : Peut avoir un ou plusieurs `user_vehicle` rattaché(s).
- `vehicle` : Est lié à un `user` et un `vehicle_model`.

Pour les tests :
- Fonctionnels : Être sûr que tout fonctionne comme prévu, que les permissions sont valides, etc. Vous pouvez utiliser par exemple [Behat](https://docs.behat.org/en/latest/) pour les tests et [AliceBundle](https://github.com/hautelook/AliceBundle) pour les fixtures.
- Unitaires : Tester unitairement vos fonctions, traitement métier, etc. avec [PHPUnit](https://symfony.com/doc/current/testing.html#unit-tests).

#### Rôles utilisateur

| Rôle               | Hiérarchie      | Définition                                                             |
| ------------------ | --------------- | ---------------------------------------------------------------------- |
| `ROLE_SUPER_ADMIN` | `ROLE_ADMIN`    | Développeurs, directeur général du réseau, département informatique... |
| `ROLE_ADMIN`       | `ROLE_EMPLOYEE` | Chef de concession                                                     |
| `ROLE_EMPLOYEE`    | `ROLE_USER`     | Employés                                                               |
| `ROLE_CUSTOMER`    | `ROLE_USER`     | Clients                                                                |
| `ROLE_USER`        | -               | Rôle par défaut                                                        |

#### Routes

##### Administration 

**Sous-domaine : `admin`**

Note : Il faudra rediriger la route `/` de l'administration (`http://admin.test-symfony.vlabs/`) vers la route qui liste les utilisateurs.

| Page                                                          | Route                         |
| ------------------------------------------------------------- | ----------------------------- |
| Connexion                                                     | `/login`                      |
| Déconnexion                                                   | `/logout`                     |
| Détail du profil                                              | `/users/self`                 |
| Modification du profil                                        | `/users/self/update`          |
| Liste des utilisateurs                                        | `/users`                      |
| Détail d'un utilisateur et liste de ses véhicules             | `/users/{id}`                 |
| Ajout d'un utilisateur                                        | `/users/create`               |
| Modification d'un utilisateur et de la liste de ses véhicules | `/users/{id}/update`          |
| Suppression d'un utilisateur                                  | `/users/{id}/delete`          |
| Liste des concessions                                         | `/concessions`                |
| Détail d'une concession                                       | `/concessions/{id}`           |
| Ajout d'une concession                                        | `/concessions/create`         |
| Modification d'une concession                                 | `/concessions/{id}/update`    |
| Suppression d'une concession                                  | `/concessions/{id}/delete`    |
| Liste des modèles de véhicule                                 | `/vehicle-models`             |
| Détail d'un modèle de véhicule                                | `/vehicle-models/{id}`        |
| Ajout d'un modèle de véhicule                                 | `/vehicle-models/create`      |
| Modification d'un modèle de véhicule                          | `/vehicle-models/{id}/update` |

##### API

**Sous-domaine : `api`**

Note : Pour vos tests, vous pouvez utiliser [Postman](https://www.postman.com/).

| Action                                     | Méthode  | Route                            |
| ------------------------------------------ | -------- | -------------------------------- |
| Remontée des véhicules de l'utilisateur    | `GET`    | `/users/{id}/vehicles`           |
| Ajout d'un véhicule pour l'utilisateur     | `POST`   | `/users/{id}/vehicles`           |
| Suppression d'un véhicule de l'utilisateur | `DELETE` | `/users/{user_id}/vehicles/{id}` |
| Détail du profil de l'utilisateur          | `GET`    | `/users/{id}`                    |
| Modification du profil de l'utilisateur    | `PUT`    | `/users/{id}`                    |

#### Permissions

##### Administration

| Action                                                     | Rôle(s) ou règle(s) nécessaire(s)                                                                   |
| ---------------------------------------------------------- | --------------------------------------------------------------------------------------------------- |
| Connexion                                                  | Accès à la page : `IS_AUTHENTICATED_ANONYMOUSLY`. Pouvoir se connecter : `ROLE_EMPLOYEE` au minimum |
| Ensemble des actions sur les concessions                   | `ROLE_SUPER_ADMIN`                                                                                  | 
| Ajout, édition, suppression des utilisateurs               | Rôle supérieur au rôle de l'utilisateur administré                                                  |
| Liste et détail des utilisateurs                           | `ROLE_EMPLOYEE` au minimum                                                                             |
| Ajout, édition, suppression des modèles de véhicule        | `ROLE_SUPER_ADMIN`                                                                                  |
| Liste et détail des modèles de véhicule                    | `ROLE_EMPLOYEE` au minimum                                                                          |
| Ensemble des actions sur les clients et de leurs véhicules | `ROLE_EMPLOYEE` au minimum                                                                          |
| Ensemble des actions sur le profil                         | `ROLE_EMPLOYEE` au minimum                                                                          |

##### API

Seulement les utilisateurs ayant le rôle `ROLE_CUSTOMER` pourront accéder aux routes de l'API nécessitant une authentification.

| Action                                                | Rôle(s) ou règle(s) nécessaire(s)                               |
| ----------------------------------------------------- | --------------------------------------------------------------- |
| Ensemble des actions sur les données d'un utilisateur | L'utilisateur authentifié doit être le propriétaire des données |

### :dart: &nbsp;Objectifs à atteindre

- Savoir installer et configurer un projet Symfony.
- Savoir administrer une entité pour : créer, lister avec recherche et pagination, afficher le détail, mettre à jour et supprimer.
- Savoir intégrer une interface d'administration simple.
- Savoir sécuriser une administration via une connexion obligatoire et des permissions accordées selon les actions demandées et le rôle de l'utilisateur connecté.
- Savoir créer une API REST pour exposer et manipuler des données.
- Savoir faire des tests fonctionnels et unitaires.
- Savoir utiliser le pattern MVC pour la conception du code.
- Connaître et comprendre les principes de base de Symfony : Routing, Controller, Repository, Mapping, Templates, Forms, Validations, Services...

### :warning: &nbsp;Conditions à remplir

- Utiliser [les concepts de flexbox](https://developer.mozilla.org/fr/docs/Web/CSS/CSS_Flexible_Box_Layout/Concepts_de_base_flexbox) pour les layouts en CSS ([guide de CSS-Tricks](https://css-tricks.com/snippets/css/a-guide-to-flexbox/)).
- Utiliser le standard [ECMAScript 2015](https://www.w3schools.com/js/js_es6.asp) (ES6) ou une version plus récente pour le JavaScript, principalement pour la déclaration de variables et de fonctions. jQuery est accepté, sans être recommandé.
- Bien configurer le `.gitignore` pour Symfony, l'IDE utilisé ainsi que les potentiels vendors et dépendances Node. Les générateurs sont utilisables, par exemple [gitignore.io](https://www.toptal.com/developers/gitignore), mais ne pas se fier aveuglément au résultat généré et bien tester que le projet est utilisable une fois cloné avec les fichiers ignorés. Si des fichiers nécessaires sont ignorés, comme le `.env` par exemple, une copie devra être présente dans le repository, nommée dans ce cas précis `.env.dist`. Nous utiliserons cette copie pour remplacer la version originale ignorée par Git pendant notre test du projet. Préciser les fichiers concernés en haut du `README.md`.

### :heavy_check_mark: &nbsp;Bonus pouvant être réalisés

- [ ] Utiliser [FOSOAuthServerBundle](https://packagist.org/packages/friendsofsymfony/oauth-server-bundle) ou un équivalent pour gérer la connexion à l'API via le protocole OAuth. Routes à rajouter : `/oauth/v2/token` pour obtenir son access token. Optionnellement `/oauth/v2/disconnect` pour supprimer les tokens de l'utilisateur en base de données et donc le déconnecter.
- [ ] Mettre en place un export CSV de la liste des utilisateurs (ceux remontés, en ignorant la pagination, mais en prenant en compte les potentiels critères de recherche).
  - [ ] ... et générer l'export de manière asynchrone avec une notion de queue comme il est possible de faire avec [JMSJobQueueBundle](https://packagist.org/packages/jms/job-queue-bundle) ou le composant [Messenger](https://symfony.com/doc/current/messenger.html) de Symfony.
- [ ] Utiliser des [Voters](https://symfony.com/doc/current/security/voters.html) pour gérer les permissions de chaque action.
- [ ] Utiliser [Select2](https://select2.org/) pour les champs `EntityType`.
- [ ] Ajouter une couche Service au MVC. Pour mieux comprendre, voici le fonctionnement : Effectuer la logique métier, toutes les manipulations et les appels au Model dans un service à part, permettant d'alléger le code présent dans le Controller. Pour vous guider, voici comment communiquent les différentes couches : Model <--> Service <--> Controller <--> View.
- [ ] Utiliser le paradigme Domain Driven Design pour l'architecture de votre code. Voici [un aperçu](./exemple-ddd.png) d'architecture pouvant correspondre à votre besoin.
- [ ] Consommer l'[API Dailymotion](https://developer.dailymotion.com/tools/) grâce au composant [HTTP Client](https://symfony.com/doc/current/http_client.html) de Symfony. Vous pourrez donc embed dans une `iframe` sur la page détail d'un modèle de véhicule une vidéo en lien avec ce dernier.
- [ ] Ne pas utiliser l'autowiring mais l'injection de dépendances via le `services.yaml` (vous pouvez dans ce fichier faire des `imports`, conseillé pour pouvoir séparer de manière logique vos services, et utiliser des fichiers au formal XML).
- [ ] Utiliser le format YAML pour le routing et les validations de formulaire. Utiliser le format XML pour le mapping Doctrine. Dans l'idée, quand il est possible d'utiliser un autre format que les annotations, le privilégier.
- [ ] Gérer de l'upload de média pour mettre une image sur les modèles de voiture et le remonter visuellement sur l'interface dans la liste et la page détail.
- [ ] Utiliser des traductions (seulement en français) dans les templates plutôt que des textes en dur.
- [ ] Utiliser un framework CSS. [Bootstrap](https://getbootstrap.com/) dans sa dernière version recommandé. Dans le cas d'un import via un pré-processeur CSS, vous n'êtes pas obligé d'inclure la librairie entière, par exemple, vous pourriez n'avoir besoin que de la grille ou des mixins mais pas des règles de style des boutons ou des modals.
- [ ] Utiliser un pré-processeur CSS. [Sass](https://sass-lang.com/guide) recommandé.
  - [ ] ... et utiliser les fonctionnalités et bonnes pratiques du pré-processeur (variables, mixins, extend, placeholder...).
  - [ ] ... et mettre en place une architecture suivant le [pattern 7-1](https://sass-guidelin.es/fr/#le-pattern-7-1).
- [ ] Utiliser [Webpack Encore](https://symfony.com/doc/current/frontend.html) pour la gestion des assets (CSS/JavaScript/Images/Fonts). Installation des dépendances via [Yarn](https://yarnpkg.com/) recommandée.
- [ ] Utiliser [Babel](https://babeljs.io/setup#installation) (fonctionne avec Webpack via le babel-loader, informations sur la page d'installation de Babel), [Browserslist](https://github.com/browserslist/browserslist) ([preview des compatibilités grâce à la configuration](https://browserl.ist/)) et le post-processeur [Autoprefixer](https://github.com/postcss/autoprefixer) (fonctionne aussi avec Webpack) pour que le JavaScript et le CSS (dans la mesure du possible) soient compatibles sur les navigateurs Chrome, Firefox, Edge, Internet Explorer, Safari et sur leur version mobile Android et iOS.

## :thumbsup: &nbsp;Créateur

* **{Votre nom}** - *Projet initial* - [V-labs](https://github.com/V-labs/test-symfony)

----

<p align="center">
    <strong><a href="http://www.v-labs.fr/" target="_blank">Site V-labs</a></strong>
    •
    <strong><a href="https://github.com/V-labs" target="_blank">GitHub V-labs</a></strong>
</p>

----
