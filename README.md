# WebUntis Vertretungsplan App
> Eine Webseite und App, die Schülern und Schülerinnen, eine verbesserte und optimierte Übersicht über ihre Vertretungsstunden bietet (WebUntis basierend)

![](https://repository-images.githubusercontent.com/305484442/8d30aa00-125c-11eb-996d-6a584ed9b439)

Mit der Vertretungsplan App bist du immer auf dem Laufenden wie es um deinen Stundenplan steht. Du kannst bis zu drei Tage im Voraus einsehen, wann du Vertretung, EVA oder Entfall hast um so nie mehr unnötigerweise zur Schule zu kommen, obwohl der Unterricht entfällt. Die App eignet sich für jeden, der an einer Schule ist, die WebUntis benutzt und das zur App gehörende Vertretungsplan System hat.

## Voraussetzungen (für die Installation und Administration)
* Deutsch Kenntnisse, da das gesamte System auf Deutsch läuft. _(Knowledge of German, as the entire system runs in German.)_
* Ein internetfähiger Linuxbasierter Computer mit Apache24, PHP7 und Curl
* Ein Funktionsfähiges WebUntis System
* Zugangsdaten für Schüler, die die Berechtigung haben die nächsten drei Tage zu sehen.
* HTML, PHP & GitHub Kenntnisse (optional)
* Kenntnisse im Umgang mit der Shell Konsole & grundlegende Erfahrung in der Webentwicklung

## Installation

Linux:

```sh
sudo apt update && sudo apt upgrade -y && sudo apt autoremove -y
sudo apt install git
git clone https://github.com/tomtactom/WebUntis-Vertretungsplan-App.git
cd WebUntis-Vertretungsplan-App
mv untis.rm.inc.php untis.inc.php
nano untis.inc.php
```
Fülle nun diese Datei aus
```php
<?php
	#$hash = hash('sha512', 'd[0<~]PH'.'V3rtr3tung-42'.'94j|i4BY');
	$hash = '2938324fa26cf8716bbb74edae6224bad017d5a6bf65a232ecf9e99d0d6aac57eec7f7f523437502f23c28d09f2c11abd31d819535a50a3e8d5dd63ecbb13c6f'; // V3rtr3tung-42   // Bitte ändere das Passwort sobald es geht!
	# Untis Login Daten in Datei ./untis.inc.php eingeben
	$schooldomain = ''; // Gebe die Schul-Internetseite ein, über die WebUntis läuft
	$schoolname = ''; // Gebe den Schulnamen ein, über den WebUntis läuft
	$webuntis_username = ''; // Gebe den Schüler Benutzernamen von WebUntis ein
	$webuntis_password = ''; // Gebe das Schüler Passwort von WebUntis ein
  $authcode = ''; // Gebe einen 32 stelligen, zufällig generierten Code ein, der aus Kleinbuchstaben und Zahlen besteht ; Für die Verbindung zur App (Wird als GET Parameter übermittelt, nirgendwo offen ausgeben)
    $sessionID = $untis->auth($schooldomain, $schoolname, $webuntis_username, $webuntis_password);
```

Erstelle in dem Verzeichnis _./icon/_ eine Datei mit dem Namen _qrcode.png_ Diese sollte einen QR-Code mit folgenden Informationen Enthalten und eine Größe von 300x300 Pixeln haben.
_Inhalt QR-Code: z.B._ `https://example.com?authcode=1c9d1b1f8a0e95e3bdd2025e1940a0d7`

Der Inhalt des Parameters `authcode` sollte dabei dem gleichen Inhalt, der in der Datei _untis.inc.php_ als `$authcode` steht, entsprechen.

Beispiel für einen QR-Code Generator: [qrcode-generator.de](https://www.qrcode-generator.de/)

Windows:

_Leider ist für dieses Betriebssystem (noch) keine Version verfügbar. Es kann jedoch sein, dass es auch auf Windows so ähnlich laufen wird, jedoch wird eine Installation, alleine schon aus Datenschutzgründen auf einem Linux basierenden Computer empfohlen._

## Anwendung

Es gibt eine Internetseite und eine App. Die Internetseite wird von der Bildungsinstitution selber gehostet, die App, kann man sich (nur für Android) im [Play Store herunterladen](https://play.google.com/store/apps/details?id=de.app.stundenplan.stundenplant)

* Nachdem die Internetseite eingerichtet wurde, wird dem Schüler die Internetseite, das Passwort, der Link zu der App, die WebUntis Domain und der Authcode zur Verfügung gestellt
* Der Schüler läd sich die App aus dem Play Store herunter, gibt das Passwort auf der Internetseite ein und bekommt einen QR Code angezeigt, welchen er mit der App scannt
* Alternativ kann der QR Code, zusammen mit einer entsprechenden Anleitung auch ausgedruckt werden
* Schüler die kein Android Smartphone besitzen können die Internetseite mit dem jeweiligen Passwort verwenden.
* Jetzt sollte es jedem möglich die Vertretungsstunden sich jederzeit ansehen zu können.

## Versionsverlauf

* 1.0
    * Die erste richtige Veröffentlichung.

## Metadaten

Tom – [Github: @tomtactom](https://github.com/tomtactom) – [WhatsApp](http://wa.me/00491788724382/?text=Hallo+Tom%2C%0D%0AIch+habe+auf+GitHub+dein+Projekt:+WebUntis+Vertretungsplan+App+-+https%3A%2F%2Fgithub.com%2Ftomtactom%2FWebUntis-Vertretungsplan-App.git+gefunden+und+habe+eine+Anmerkung+dazu.)
Emre - [Github: @emredevde](ttps://github.com/emredevde)

 _Wenn du bei dem Projekt mitarbeiten möchtest, schreibe einem der Entwickler per WhatsApp_

'Vertretungsplan' von 'Tom Aschmann' ist lizenziert
unter einer Creative Commons Namensnennung
Nicht kommerziell 4.0 International Lizenz
Um eine Kopie dieser Lizenz zu sehen, besuchen Sie
[creativecommons.org/licenses/by-nc/4.0](http://creativecommons.org/licenses/by-nc/4.0/)

