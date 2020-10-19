<?php
  /*
    'Vertretungsplan' von 'Tom Aschmann' ist lizenziert
    unter einer Creative Commons Namensnennung
    Nicht kommerziell 4.0 International Lizenz
    Um eine Kopie dieser Lizenz zu sehen, besuchen Sie
    http://creativecommons.org/licenses/by-nc/4.0/
  */
  // Der header wird eingefügt
  require('header.inc.php');
  // Der Vertretungsplan wird angezeigt
  if ($show_site === true) {
?>
    <table>
      <tr><th>Stunde</th><th>Fach</th><th>Vertretung</th><th>Raum</th></tr>
<?php
  $counter = 0; // Zählt alle einzelnen verfügbaren Stunden
  $val_counter = 0; // Zählt alle Stunden die eine Änderung eingetragen haben
  // Schleife in der alle einzelnen Stunden durchgegangen werden
	foreach (timetableData(date("Ymd", strtotime('+'.$day_number.' days')))['data']['dayTimeTable'] as $lessondate_main) {
    $counter = $counter + 1; //Counter (siehe oben)
    // Überprüft den zur Stunde zugehörigen Lehrer und teilt diese auf, wenn zwei eingetragen sind
    $lesson['teacher']['tmp'] = explode(',', $lessondate_main['teacher']);
    if(empty($lesson['teacher']['tmp'][0])) {
      $lesson['teacher'][0] = $lessondate_main['teacher'];
    } else {
      $lesson['teacher'][0] = $lesson['teacher']['tmp'][0];
      $lesson['teacher'][1] = $lesson['teacher']['tmp'][1];
    }
    // Überprüft den zur Stunde zugehörigen Raum und teilt diese auf, wenn zwei eingetragen sind
    $lesson['room']['tmp'] = explode(',', $lessondate_main['room']);
    if(empty($lesson['room']['tmp'][0])) {
      $lesson['room'][0] = $lessondate_main['room'];
    } else {
      $lesson['room'][0] = $lesson['room']['tmp'][0];
      $lesson['room'][1] = $lesson['room']['tmp'][1];
    }
    // Speichert das zugehörige Fach, die zugehörige Stunde, den Code und die zugehörige ID ab
    $lesson['subject'] = $lessondate_main['subject'];
    $lesson['timeGridHour'] = $lessondate_main['timeGridHour'];
    $lesson['id'] = $lessondate_main['periods'][0]['id'];
    $lesson['code'] = $lessondate_main['periods'][0]['isCancelled'];
    // Überprüft ob es eine änderung gibt und filtert Fächer mit Änderungen von Fächern ohne Änderungen
  	if ($lesson['code'] == 'cancelled') {
  		echo '      <style>.a'.$lesson['id'].' { background-color: #3498db; color: #fff; }</style>
';
      $lesson['teacher'][0] = 'Entfall';
  		$anomaly0 = true;
  	} elseif ($lesson['code'] == 'irregular') {
  		echo '      <style>.a'.$lesson['id'].' { background-color: #d35400; color: #fff; }</style>
';
      $lesson['teacher'][0] = '???';
  		$anomaly0 = true;
  	} elseif (strpos($lesson['teacher'][0], '.EVA.') !== false) {
      echo '      <style>.a0_'.$lesson['id'].' { background-color: #2980b9; color: #fff; }</style>
';
      $anomaly0 = true;
    } elseif (strpos($lesson['teacher'][0], '.NN.') !== false) {
      echo '      <style>.a0_'.$lesson['id'].' { background-color: #e74c3c; color: #fff; }</style>
';
      $anomaly0 = true;
    } elseif (strpos($lesson['room'][0], '(') !== false) {
      $anomaly0 = true;
    } elseif (strpos($lesson['teacher'][0], '(') !== false) {
      $anomaly0 = true;
    }
    // Überprüft das gleiche, wenn ein zweiter Wert für die gleiche Stunde eingetragen ist
    if ($lesson['code'] == 'cancelled') {
  		echo '      <style>.a'.$lesson['id'].' { background-color: #3498db; color: #fff; }</style>
';
      $lesson['teacher'][1] = 'Entfall';
  		$anomaly1 = true;
  	} elseif ($lesson['code'] == 'irregular') {
  		echo '      <style>.a'.$lesson['id'].' { background-color: #d35400; color: #fff; }</style>
';
      $lesson['teacher'][1] = '???';
  		$anomaly1 = true;
  	} elseif (strpos($lesson['teacher'][1], '.EVA.') !== false) {
      echo '      <style>.a1_'.$lesson['id'].' { background-color: #2980b9; color: #fff; }</style>
';
      $anomaly1 = true;
    } elseif (strpos($lesson['teacher'][1], '.NN.') !== false) {
      echo '      <style>.a1_'.$lesson['id'].' { background-color: #e74c3c; color: #fff; }</style>
';
      $anomaly1 = true;
    } elseif (strpos($lesson['room'][1], '(') !== false) {
      $anomaly1 = true;
    } elseif (strpos($lesson['teacher'][1], '(') !== false) {
      $anomaly1 = true;
    }
    // Gibt die Stunde aus, wenn es eine Änderung gibt aus dem ersten Teil
  	if($anomaly0 === true) {
  		echo '      <tr class="a0_'.$lesson['id'].'"><td>'.$lesson['timeGridHour'].'</td><td>'.$lesson['subject'].'</td><td>'.str_replace('_GK', '', str_replace('NN', 'Abwesend', str_replace('.', '', $lesson['teacher'][0]))).'</td><td>'.$lesson['room'][0].'</td></tr>
		
';
      $val_counter = $va_counter + 1; // Counter (siehe oben)
    }
    // Gibt die Stunde aus, wenn es eine Änderung gibt aus dem zweiten Teil
    if($anomaly1 === true) {
  		if ($lesson['teacher'][1] == true && $lesson['room'][1] == true) {
  			echo '      <tr class="a1_'.$lesson['id'].'"><td>'.$lesson['timeGridHour'].'</td><td>'.$lesson['subject'].'</td><td>'.str_replace('_GK', '', str_replace('NN', 'Abwesend', str_replace('.', '', $lesson['teacher'][1]))).'</td><td>'.$lesson['room'][1].'</td></tr>
  ';
        $val_counter = $va_counter + 1; // Counter (siehe oben)
      }
    }
    // Sestzt alle Variablen auf false, damit beim ernseuten Schleifendurchgang es keine Probleme gibt
    $lesson['id'] = false;
    $lesson['timeGridHour'] = false;
    $lesson['subject'] = false;
    $lesson['teacher'][0] = false;
    $lesson['teacher'][1] = false;
    $lesson['room'][0] = false;
    $lesson['room'][1] = false;
    $anomaly0 = false;
    $anomaly1 = false;
  }
	 if(isset($_GET['analytics']) && $val_counter !== 0) {
		$analytics_file = file_get_contents('analytics'.date('Y').'.inc.txt');
		 if(empty($analytics_file)) {
			 $analytics_file = 0;
		 }
		$analytics_file = $analytics_file + $val_counter;
		file_put_contents('analytics'.date('Y').'.inc.txt', $analytics_file);
	}
?>
    </table>
	<br>
<?php if($val_counter === 0) { // Meldung, wenn es keine Änderungen gab ?>
    <h1 id="noanomaly"><?php echo $status; ?> wird nichts Vertreten</h1>
<?php
  }
  if(!isset($_GET['authcode'])) { // Footer Bar zur navigierung, für Webseitennutzer ?>
    <footer>
      <form method="post">
        <table>
          <tbody>
            <tr>
<?php if($_GET['day'] == '1' || $_GET['day'] == '2') { ?>
              <th id="before"><button type="submit" name="before"></button></th>
<?php } ?>
              <th id="status"><?php echo $status; ?></th>
<?php if($_GET['day'] == '0' || $_GET['day'] == '1' || !isset($_GET['day'])) { ?>
              <th id="after"><button type="submit" name="after"></button></th>
<?php } ?>
            </tr>
          </tbody>
        </table>
      </form>
    </footer>
<?php
    }
  }
?>
  </body>
</html>
