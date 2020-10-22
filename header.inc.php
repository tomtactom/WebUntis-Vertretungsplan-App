<?php
  require('./webuntis.inc.php');
  require('./untis.inc.php');
  // Funktion um zu ermitteln ob der Nutzer Android nutzt
  function get_user_system_info() {
    try {
      $system_info = get_browser(null, true);
      $platform = $system_info["platform"];
      $browser_name = $system_info["browser"];
      $browser_version = $system_info["version"];
    } catch(Exception $e) {
      $system_info = new Browser();
      $platform = $system_info->getPlatform();
      $browser_name = $system_info->getBrowser();
      $browser_version = $system_info->getVersion();
    }
    return $arrayName = array('platform' => $platform, 'browser_name' => $browser_name, 'browser_version' => $browser_version);
  }
  // Der authcode wird mit zwei salts als sha512 Hash verschlüsselt, damit dieser Hash nach dem Anmelden als Cookie gesetzt wird, um angemeldet zu bleiben
  $authcode_hash = hash('sha512', '5si*YTGd'.$authcode.'nw1Xe,|$');
  // Das Fake Captcha stellt eine Falle für automatische Brut Force Systeme da. Diese erkennen es als richtiges Captcha und probieren die rechenaufgabe zu lösen. Das <input> Feld ist für den Benutzer unsichtbar. Sobald etwas in ihm steht, wird der Anmeldevorgang blockiert
  $fake_captcha = rand(0, 99).'+'.rand(0,99);
  // Wenn die App den richtigen `authcode` per GET übermittelt oder der COOKIE `authcode` gesetzt ist und mit dem oben generierten $authcode_hash übereinstimmt, wird der Vertretungsplan angezeigt
  if($_GET['authcode'] === $authcode || $_COOKIE["authcode"] === $authcode_hash) {
    $show_site = true;
    // Ansonnsten wird das Anmeldeformular angezeigt
  } else {
    // Überprüft ob das Formular abgesendet wurde
    if(isset($_POST['authenticate']) || isset($_POST['authenticate_app'])) {
      // Überprüft ob das Passwortfeld Ihnalt hat und ob das Fake Captcha leer ist
      if(!empty($_POST['password']) && empty($_POST['captcha'])) {
        // Überprüft das eingegebene Passwort mit dem Hash. Wenn dies übereinstimmt wird der Vertretungsplan angezeigt und der COOKIE `authcode` mit dem $authcode_hash für 12 Stunden gesetzt
        if (hash('sha512', 'd[0<~]PH'.$_POST['password'].'94j|i4BY') === $hash) {
		  $counter = file_get_contents('./counter.web.inc.php');
		  $counter = $counter + 1;
		  file_put_contents('./counter.web.inc.php', $counter);
		  if (isset($_POST['authenticate_app'])) {
			$show_qrcode = true;
		  } else {
			$show_site = true;
			setcookie("authcode", $authcode_hash, time() + (3600 * 12));
		  }
          // Wenn es nicht übereinstimmt wird die jeweilige Benachrichtigung angezeigt
        } else {
          $msg = 'Das<span style="color: transparent;">'.rand(0, 9).'</span>Passwort<span style="color: transparent;">'.rand(0, 9).'</span>war<span style="color: transparent;">'.rand(0, 9).'</span>leider<span style="color: transparent;">'.rand(0, 9).'</span>falsch'; // rand(0, 9), ist als Sicherheitsvorkehrung vor Brute Force Angriffen wie von hydra.
        }
        // Wenn das Passwort Feld leer ist oder das Captcha Feld ausgefüllt wurde, wird die jeweilige Benachrichtigung angezeigt
      } else {
        $msg = 'Bitte gebe ein Passwort ein';
      }
    }
  }
  // Wenn GET `day` nicht den vorgegebenen Werten entspricht, wird es entdefediniert
  if($_GET['day'] != '0' && $_GET['day'] != '1' && $_GET['day'] != '2') {
    unset($_GET['day']);
  }
  // Footer Status Bar: Regelt das Formular mit dem man zwischen den Ereignissen "Heute", "Morgen" und "Übermorgen" springen kann
  if(!isset($_GET['day']) || $_GET['day'] == '0') {
    $status = 'Heute';
    $day_number = 0;
    if(isset($_POST['after'])) {
      header('Location: '.explode('?', $_SERVER['REQUEST_URI'])[0].'?day=1');
      $status = 'Morgen';
    }
  } elseif($_GET['day'] == '1') {
    $status = 'Morgen';
    $day_number = 1;
    if(isset($_POST['before'])) {
      header('Location: '.explode('?', $_SERVER['REQUEST_URI'])[0]);
      $status = 'Heute';
    }
    if(isset($_POST['after'])) {
      header('Location: '.explode('?', $_SERVER['REQUEST_URI'])[0].'?day=2');
      $status = 'Übermorgen';
    }
  } elseif($_GET['day'] == '2') {
    $status = 'Übermorgen';
    $day_number = 2;
    if(isset($_POST['before'])) {
      header('Location: '.explode('?', $_SERVER['REQUEST_URI'])[0].'?day=1');
      $status = 'Morgen';
    }
  }
?>
<html lang="de">
  <head>
    <meta charset="utf-8">
<?php
  // Wenn das Anmeldeformular angezeigt wird, wird der viewport auf 'width=device-width, initial-scale=1' gesetzt, damit das es auf dem Handy und Tablet eine besser größe hat
  if($show_site == false) {
?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      body {
        padding-bottom: 0!important;
      }
    </style>
<?php } ?>
  	<title>Vertretungsplan</title>
  	<meta name="language" content="de">
  	<meta name="date" content="2019-05-10">
  	<meta name="keywords" content="Untis, Stundenplan, Vertretungsplan, Vertretungsplan App">
  	<meta name="description" content="Es werden dir alle Schulstunden angezeigt, bei denen es eine Änderung gibt.">
    <meta name="lizenz" content="'Vertretungsplan' von 'Tom Aschmann' ist lizenziert unter einer Creative Commons Namensnennung Nicht kommerziell 4.0 International Lizenz Um eine Kopie dieser Lizenz zu sehen, besuchen Sie http://creativecommons.org/licenses/by-nc/4.0/">
    <meta property="st:section" content="Es werden dir alle Schulstunden angezeigt, bei denen es eine Änderung gibt.">
    <meta name="twitter:title" content="Vertretungsplan">
    <meta name="twitter:description" content="Es werden dir alle Schulstunden angezeigt, bei denen es eine Änderung gibt.">
    <meta name="twitter:card" content="summary_large_image">
  	<meta name="robots" content="noindex, nofollow">
  	<meta name="author" content="Tom Aschmann">
    <meta name="copyright" content="©<?php echo date('Y'); ?> Tom Aschmann">
    <meta name="publisher" content="Tom Aschmann">
    <meta name="msapplication-TileColor" content="#2c3e50">
    <meta name="theme-color" content="#34495e">
    <meta name="msapplication-TileImage" content="./icon/ms-icon-144x144.png">
    <meta http-equiv="language" content="deutsch, de">
  	<link rel="apple-touch-icon" sizes="57x57" href="./icon/apple-icon-57x57.png">
  	<link rel="apple-touch-icon" sizes="60x60" href="./icon/apple-icon-60x60.png">
  	<link rel="apple-touch-icon" sizes="72x72" href="./icon/apple-icon-72x72.png">
  	<link rel="apple-touch-icon" sizes="76x76" href="./icon/apple-icon-76x76.png">
  	<link rel="apple-touch-icon" sizes="114x114" href="./icon/apple-icon-114x114.png">
  	<link rel="apple-touch-icon" sizes="120x120" href="./icon/apple-icon-120x120.png">
  	<link rel="apple-touch-icon" sizes="144x144" href="./icon/apple-icon-144x144.png">
  	<link rel="apple-touch-icon" sizes="152x152" href="./icon/apple-icon-152x152.png">
  	<link rel="apple-touch-icon" sizes="180x180" href="./icon/apple-icon-180x180.png">
  	<link rel="icon" type="image/png" sizes="192x192"  href="./icon/android-icon-192x192.png">
  	<link rel="icon" type="image/png" sizes="32x32" href="./icon/favicon-32x32.png">
  	<link rel="icon" type="image/png" sizes="96x96" href="./icon/favicon-96x96.png">
  	<link rel="icon" type="image/png" sizes="16x16" href="./icon/favicon-16x16.png">
  	<link rel="manifest" href="./icon/manifest.json">
    <link rel="stylesheet" type="text/css" href="./style.css">
  </head>
  <body oncontextmenu="return false">
<?php
  if($show_site == false) {
?>
    <main>
      <section>
	  <?php
		if ($show_qrcode == true) {
	  ?>
	  <div class="field"><img src="./icon/qrcode.png" style="max-width:100%;height:auto;"></div>
    <p>Wenn du ein Android Smartphone besitzt, scanne diesen QR-Code mit der <a href="https://play.google.com/store/apps/details?id=de.app.stundenplan.stundenplant" target="_blank" rel="external">Vertretungsplan App</a> von Tom Aschmann. Weitere Informationen findest du bei deiner Bildungseinrichtung.</p>
	  <?php
		} else {
	  ?>
        <form method="post">
          <h3>Vertretungsplan</h3>
<?php if(!empty($msg)) { ?>
          <h4><?php echo $msg; ?></h4>
<?php } ?>
          <label><?php echo $fake_captcha; ?>
            <input type="text" name="captcha" placeholder="<?php echo $fake_captcha; ?>">
          </label>
          <label>Passwort:
            <input type="password" name="password" placeholder="Passwort" title="Gebe hier das Passwort ein um auf den Vertretungsplan zuzugreifen" maxlength="64" autofocus required>
          </label>
          <button type="submit" name="authenticate" title="Du bleibt für 12 Stunden angemeldet">Anmelden</button>
          <?php
              if (!file_exists('./icon/qrcode.png')) {
                echo '<small>Ein QR-Code zur Anmeldung per App ist noch nicht verfügbar. Bitte kontaktiere den Administrator dieser Webseite, einen zu erstellen.</small>';
              } else {
          ?>
		        <button type="submit" name="authenticate_app" title="Scanne den QR-Code um die App benutzen zu können">QR-Code Scannen</button>
          <?php } ?>
        </form>
		<?php } ?>
      </section>
    </main>
<?php } ?>
