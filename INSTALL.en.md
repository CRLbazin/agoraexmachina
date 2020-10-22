# Installation of the liquid democracy platform Agora Ex Machina (AEM)

## Copying files

### If you are not familiar with a git repository

* Download and unzip the archive locally
* Add the infos in the .env file, at the end of the file, add the information related to the database server (address, login, password, database name) according to the template provided for this purpose.
* Copy all the files in a directory named agoraexmachina.

### If you are familiar with a git repository

* Use `git clone` to download all the files needed for installation. 

## Installation

### Preamble

**AgoraExMachina** is developed using the Symfony Framework. It is necessary :

* either to install the package manager `Composer` to your php/MySQL server
* or use `composer.phar` to allow packet acquisition.

### With dial

`compile install --nodev --optimize --autoloader`.

`sudo composer require symfony/dotenv:^4.4`

`php bin/console doctrine:schema:update -force`

### With composer.phar

`php composer.phar install` in the agoraexmachina directory

`php composer.phar install --nodev --optimize --autoloader`

`php composer.phar require symfony/dotenv:^4.4`

`php bin/console doctrine:schema:update -force`

### Post-installation procedure

* In a browser, go to the AEM administration interface (http://mondomaine.com/agoraexmachina)
* Add an account (top right, **Signin**)
* Click on **or create an account**.
* Create your account 
* In the phpMyadmin interface (or command line), add `["ROLE_ADMIN"]` in the `user` table, column `roles`. This action allows you to become administrator. 
* You may have to log in again with your new status.

## Remarks
The liquid democracy solution is under development, and some installation bugs remain. Don't despair during installation. These few tips will surely help you: 

* Perform a local mode installation first. Once this operation is successful, you will have access to all the Symfony packages in the vendor directory. 
* If you try to install AEM using the commands `composer install --nodev --optimize --autoloader` and `sudo composer require symfony/dotenv:^4.4` and you receive error messages, you can copy the `vendor` directory to the root of your remote directory. Then by repeating the same command lines, your installation will run smoothly.
* When installing the database, if you get error messages about an invalid `utf8mb4_unicode_ci`, you will have to do this installation manually by exporting the code of the database tables (from `user`) and to install the tables directly, for example from your phpMyAdmin interface, correcting the string *utf8mb4_unicode_ci* for the `user` table with *utf8_unicode_ci*. This procedure can be applied to all `user' tables, and following ones.

For any bug related to the installation, please contact the author.**

Translated with www.DeepL.com/Translator (free version)