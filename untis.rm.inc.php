<?php
  // Benenne diese Datei um (untis.inc.php) und vervollständige den Inhalt:

	#$hash = hash('sha512', 'd[0<~]PH'.'V3rtr3tung-42'.'94j|i4BY');
	$hash = '2938324fa26cf8716bbb74edae6224bad017d5a6bf65a232ecf9e99d0d6aac57eec7f7f523437502f23c28d09f2c11abd31d819535a50a3e8d5dd63ecbb13c6f'; // V3rtr3tung-42   // Bitte ändere das Passwort sobald es geht!
	# Untis Login Daten in Datei ./untis.inc.php eingeben
	$schooldomain = ''; // Gebe die Schul-Internetseite ein, über die WebUntis läuft
	$schoolname = ''; // Gebe den Schulnamen ein, über den WebUntis läuft
	$webuntis_username = ''; // Gebe den Schüler Benutzernamen von WebUntis ein
	$webuntis_password = ''; // Gebe das Schüler Passwort von WebUntis ein
    $authcode = ''; // Gebe einen 32 stelligen, zufällig generierten Code ein, der aus Kleinbuchstaben und Zahlen besteht ; Für die Verbindung zur App (Wird als GET Parameter übermittelt, nirgendwo offen ausgeben)
						#auth('url', 'schoolname', 'username', 'password');
    $sessionID = $untis->auth($schooldomain, $schoolname, $webuntis_username, $webuntis_password);
