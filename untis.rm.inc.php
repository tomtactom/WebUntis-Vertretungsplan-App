<?php
  // Benenne diese Datei um (untis.inc.php) und vervollständige den Inhalt:

	#$hash = hash('sha512', 'salt'.'passwort'.'salt');
	$hash = '???'; // passwort   // Bitte ändere das Passwort sobald es geht!
	# Untis Login Daten in Datei ./untis.inc.php eingeben
	$schooldomain = ''; // Gebe die Schul-Internetseite ein, über die WebUntis läuft
	$schoolname = ''; // Gebe den Schulnamen ein, über den WebUntis läuft
	$webuntis_username = ''; // Gebe den Schüler Benutzernamen von WebUntis ein
	$webuntis_password = ''; // Gebe das Schüler Passwort von WebUntis ein
    $authcode = ''; // Gebe einen 32 stelligen, zufällig generierten Code ein, der aus Kleinbuchstaben und Zahlen besteht ; Für die Verbindung zur App (Wird als GET Parameter übermittelt, nirgendwo offen ausgeben)
						#auth('url', 'schoolname', 'username', 'password');
    $sessionID = $untis->auth($schooldomain, $schoolname, $webuntis_username, $webuntis_password);
