# Installation de la plateforme de démocratie liquide Agora Ex Machina (AEM)

## Copie des fichiers

### Si vous n’êtes pas familier avec un repository git

* Télécharger et décompresser l’archive en local
* Ajouter les infos dans le fichier .env, en fin de fichier, ajoutez les informations relatives au serveur de bases de données (adresse, identifiant, mot de passe, nom de la base de données) selon le modèle prévu à cet effet.
* Copiez l’ensemble des fichiers dans un répertoire nommé agoraexmachina

### Si vous êtes familier avec un repository git

* Utilisez `git clone` pour télécharger l'ensemble des fichiers nécessaires à  l'installation. 

## Installation

### Préambule

**AgoraExMachina** est développé à l'aide du Framework Symfony. Il est nécessaire :

* soit d'installer le gestionnaire de paquets `Composer` à votre serveur php/MySQL
* soit d'utiliser `composer.phar` pour permettre d'acquisition des paquets.

### Avec composer

`composer install --nodev --optimize --autoloader`

`sudo composer require symfony/dotenv:^4.4`

`php bin/console doctrine:schema:update —force`

### Avec composer.phar

`php composer.phar install` dans le répertoire agoraexmachina

`php composer.phar install --nodev --optimize --autoloader`

`php composer.phar require symfony/dotenv:^4.4`

`php bin/console doctrine:schema:update —force`

### Procédure post-installation

* Dans un navigateur, se placer dans l’interface d’administration de AEM (http://mondomaine.com/agoraexmachina)
* Ajouter un compte (en haut à droite, **Signin**)
* Cliquer sur **or create an account**
* Créer votre compte 
* Dans l'interface phpMyadmin (ou en ligne de commande), ajoutez `["ROLE_ADMIN"]` dans la table `user`, colonne `roles`. Cette action vous permet de devenir administrateur. (attention, ce ne sont pas de double quotes, mais deux simple quotes).
* Vous devrez peut-être vous loguer à nouveau avec votre nouveau statut.

## Remarques
La solution de démocratie liquide est en développement, et quelques bugs d'installation restent. Ne désespérez pas lors de l'installation. Ces quelques conseils vous aideront surement : 

* Effectuez d'abord une installation en mode local. Une fois cette opération réussie, vous aurez accès à l'ensemble des paquets Symfony qui se trouvent dans le répertoire vendor. 
* Si vous tentez d'installer AEM à l'aide des commandes `composer install --nodev --optimize --autoloader` et `sudo composer require symfony/dotenv:^4.4` et que vous recevez des messages d'erreur, vous pourrez copier le répertoire `vendor` à la racine de votre répertoire distant. En recommençant ensuite les mêmes lignes de commande, votre installation se déroulera sans accroc.
* Lors de l'installation de la base de données, si vous avez des messages d'erreur faisant cas d'`utf8mb4_unicode_ci` non valide, il vous faudra faire cette installation manuellement en exportant le code des tables de la base (à partir de `user`) et de faire l'installation des tables directement, par exemple depuis votre interface phpMyAdmin, en corrigeant, pour la table `user` la chaine de caractères *utf8mb4_unicode_ci* par *utf8_unicode_ci*. Cette procédure peut être appliquée à l'ensemble des tables `user',  et suivantes.

Pour tout bug relatif à l'intallation, veuillez vous adresser à l'auteur.