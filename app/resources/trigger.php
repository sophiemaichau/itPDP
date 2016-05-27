<?php


  function update(){
    require('connection.php');

    device info
    $deviceID = "370045000f47343432313031";
    $accessToken = "3fe4bfb6eee5dfb29e74234a79664e4b4113e28c";
    $tid = "tid";
    $greb = "greb";
    $success = "success";

    // api url
    $url = "https://api.particle.io/v1/devices/".$deviceID."/".$tid."?access_token=".$accessToken;
    $url2 = "https://api.particle.io/v1/devices/".$deviceID."/".$greb."?access_token=".$accessToken;
    $url3 = "https://api.particle.io/v1/devices/".$deviceID."/".$success."?access_token=".$accessToken;

    $content = file_get_contents($url);
    $json = json_decode($content);

    $content2 = file_get_contents($url2);
    $json2 = json_decode($content2);

    $content3 = file_get_contents($url3);
    $json3 = json_decode($content3);

    $tid = $json->result;
    $greb = $json2->result;
    $success = $json3->result;


    $triggered = date('h:i:s');

    // this sql statement contains a placeholder for the variables
    $sql = "INSERT INTO test(triggered)
                VALUES (:triggered)";

    $statement = $db->prepare($sql);

    // bind values to the SQL statement
    $statement->bindValue(':triggered', $triggered);

    // execute the sql statement
    $statement->execute();
  };


  update();

  // sleep for 20 seconds
  sleep(20);

  update();

  // sleep for 20 seconds
  sleep(20);

  update();



?>
