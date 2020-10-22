# Installation der Plattform für flüssige Demokratie Agora Ex Machina (AEM)

## Dateien kopieren

### Wenn Sie mit einem Git-Repository nicht vertraut sind

* Laden Sie das Archiv lokal herunter und entpacken Sie es
* Fügen Sie die Informationen in der .env-Datei hinzu. Fügen Sie am Ende der Datei die Informationen bezüglich des Datenbankservers (Adresse, Login, Passwort, Datenbankname) entsprechend der für diesen Zweck vorgesehenen Vorlage hinzu.
* Kopieren Sie alle Dateien in ein Verzeichnis namens agoraexmachina.

### Wenn Sie mit einem Git-Repository vertraut sind

* Verwenden Sie `git clone`, um alle für die Installation benötigten Dateien herunterzuladen. 

## Installation

### Präambel

**AgoraExMachina** wird mit dem Symfony Framework entwickelt. Es ist notwendig :

* entweder den Paketmanager `Composer` auf Ihrem php/MySQL-Server zu installieren
* oder benutzen Sie `composer.phar`, um die Paketakquisition zu ermöglichen.

### Mit Wählscheibe

`kompilieren Sie install --nodev --optimieren Sie --autoloader`

`sudo composer require symfony/dotenv:^4.4`

`php bin/console doctrine:schema:update -force`

### Mit dial.phar

`php composer.phar install` im agoraexmachina-Verzeichnis

`php composer.phar install --nodev --optimize --autoloader`

`php composer.phar erfordern symfony/dotenv:^4.4`

`php bin/console doctrine:schema:update -force`

### Verfahren nach der Installation

* Gehen Sie in einem Browser auf die AEM-Verwaltungsoberfläche (http://mondomaine.com/agoraexmachina)
* Ein Konto hinzufügen (oben rechts, **Signin**)
* Klicken Sie auf **or create an account**
* Erstellen Sie Ihr Konto 
* Fügen Sie in der phpMyadmin-Schnittstelle (oder Befehlszeile) `["ROLE_ADMIN"]` zur Tabelle `user`, Spalte `roles` hinzu. Mit dieser Aktion können Sie Administrator werden.
* Möglicherweise müssen Sie sich mit Ihrem neuen Status erneut anmelden.

## Bemerkungen
Die Lösung für eine flüssige Demokratie ist in der Entwicklung, und einige Installationsfehler bleiben bestehen. Verzweifeln Sie nicht während der Installation. Diese wenigen Tipps werden Ihnen sicherlich helfen: 

* Führen Sie zuerst eine Installation im lokalen Modus durch. Sobald dieser Vorgang erfolgreich abgeschlossen ist, haben Sie Zugriff auf alle Symfony-Pakete im Anbieterverzeichnis. 
* Wenn Sie versuchen, AEM mit den Befehlen `composer install --nodev --optimize --autoloader` zu installieren und `sudo composer require symfony/dotenv:^4.4` und Sie Fehlermeldungen erhalten, können Sie das Verzeichnis `vendor` in das Wurzelverzeichnis Ihres entfernten Verzeichnisses kopieren. Wenn Sie dann die gleichen Befehlszeilen noch einmal wiederholen, wird Ihre Installation reibungslos ablaufen.
* Wenn Sie bei der Installation der Datenbank Fehlermeldungen erhalten, die besagen, dass `utf8mb4_unicode_ci` ungültig ist, müssen Sie diese Installation manuell durchführen, indem Sie den Code der Datenbanktabelle (von `user`) exportieren und die Tabellen direkt installieren, z.B. von Ihrer phpMyAdmin-Oberfläche aus, indem Sie die Zeichenkette *utf8mb4_unicode_ci* für die `user`-Tabelle mit *utf8_unicode_ci* korrigieren. Dieses Verfahren kann auf alle `Benutzer'-Tabellen und folgende angewandt werden.

Bei Installationsfehlern wenden Sie sich bitte an den Autor.

Übersetzt mit www.DeepL.com/Translator (kostenlose Version)