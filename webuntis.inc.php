<?php
  class Webuntis{
      private static $server, $school, $user, $pass, $sessionid, $klasseid, $type, $studentid;
      private static function id(){
          $id = time().rand();
          $id = md5($id);
          return $id;
      }
      public static function request($json){
          if (!function_exists('curl_init')){
              die('<a href="https://curl.haxx.se/" hreflang="en" rel="help" target="_blank">cURL</a> ist nicht installiert.');
          }
          if(isset(self::$sessionid)){
                  $url = "https://".self::$server."/WebUntis/jsonrpc.do;jsessionid=".self::$sessionid."?school=".self::$school;
          }else{
              $url = "https://".self::$server."/WebUntis/jsonrpc.do?school=".self::$school;
          }
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_HEADER, false);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          $header = array("Content-type: application/json");
          curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
          $json_response = curl_exec($curl);
          $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
          curl_close($curl);
          return json_decode($json_response, true);
      }
      public static function auth($tserver, $tschool, $tuser, $tpass){
          self::$server = $tserver; self::$school = $tschool; self::$user = $tuser; self::$pass = $tpass;
          $json = array(
              "id" => self::id(),
              "method" => "authenticate",
              "params" => array(
                  "user" => self::$user,
                  "password" => self::$pass,
                  "client" => "web"
              ),
              "jsonrpc" => "2.0"
          );
          $json = json_encode($json, true);
          $return = self::request($json);
          if(array_key_exists('error', $return)){
              die(json_encode($return["error"]));
          }
          self::$sessionid = $return["result"]["sessionId"];
          self::$klasseid = $return["result"]["klasseId"];
          self::$type = $return["result"]["personType"];
          self::$studentid = $return["result"]["personId"];
                return $return["result"]["sessionId"];
      }
  }
  function timetableData ($date, $http = false) {
    global $schooldomain, $schoolname, $sessionID;
    if ($http === true) {
      $http = 'http';
    } else {
      $http = 'https';
    }
    $url = $http.'://'.$schooldomain.'/WebUntis/api/daytimetable/dayLesson?date='.$date.'&id=833&type=5'; // Es kann sein, dass die ID angepasst werden muss
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $header = array('cookie: schoolname="'.$schoolname.'"; JSESSIONID='.$sessionID);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    $json_response = curl_exec($curl);
    return json_decode($json_response, true);
  }
  // Untis API in Variable zur verfügung stellen wird für auth() benötigt
  $untis = new Webuntis();
?>
