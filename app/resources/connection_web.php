<?php

  $dbHost = 'web89.meebox.net';
  $dbName = 'steffenm_boulder';
  $dbUser = 'steffenm_m';
  $dbCode = 'Muldbjerg91';

  try{
    $db = new PDO("mysql:host=" . $dbHost ."; dbname=" . $dbName . ";", $dbUser, $dbCode);

    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  }
  catch (Exception $e){
    echo $e->getMessage();
    exit;
  }

?>
