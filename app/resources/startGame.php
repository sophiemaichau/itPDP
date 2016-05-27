<?php

  require_once("connection.php");

  // device info
  $deviceID = "370045000f47343432313031";
  $accessToken = "3fe4bfb6eee5dfb29e74234a79664e4b4113e28c";
  $command = "sendData";

  $url = "https://api.particle.io/v1/devices/".$deviceID."/".$command."?access_token=".$accessToken;


  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);

  $game = [ $request->game ];
  $level = [ $request->level ];
  $no = [ $request->no ];
  $player1 = [ $request->player1 ];
  $player2 = [ $request->player2 ];

  

  $response = makePostRequest($url, $game);
  $response += makePostRequest($url, $level);
  $response += makePostRequest($url, $no);
  $response += makePostRequest($url, $player1);
  $response += makePostRequest($url, $player2);


  /**
   * Do a POST requests
   * @param string $url
   * @param string $data
   * @return string
   */
  function makePostRequest($url, $data) {

      // konfiguration for POST-request
      $options = array(
          'http' => array(
              'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
              'method'  => 'POST',
              'content' => http_build_query($data)
          )
      );

      $context  = stream_context_create($options);

      $result = file_get_contents($url, false, $context);

      if ($result === FALSE) {
          // noget gik galt
          die("http error, check photon is online");
      }

      return $result;
  }

?>
