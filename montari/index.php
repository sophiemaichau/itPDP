<?php
require_once("dbconnection.php");

// device info
$deviceID = "370045000f47343432313031";
$accessToken = "3fe4bfb6eee5dfb29e74234a79664e4b4113e28c";
$command = "sendData";

$url = "https://api.particle.io/v1/devices/".$deviceID."/".$command."?access_token=".$accessToken;

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
<center>
<h1>MONTARI</h1>
<form action="" method="POST">
	<input type="radio" name="game" value="sam">Samarbejd
	<input type="radio" name="game" value="mod">Modstander<br><br>
	Player 1: <input type="text" name="id1">
	Player 2: <input type="text" name="id2"><br><br>
	<h4>Sværhedsgrad</h4>
	Grøn: <input type="radio" name="farve" value="grøn"><br>
	Gul: <input type="radio" name="farve" value="gul"><br>
	Blå: <input type="radio" name="farve" value="blå"><br>
	Rød: <input type="radio" name="farve" value="rød"><br>
	<br> <br>
	Vælg antal greb: 
	<input type="number" name="greb" min="1" max="5"><br><br>
    <input type="submit" value="SPIL!">
</form>
</center>

    <?php

    // check if POST data has been submitted
    if (isset($_POST['game'])) {
        $game = $_POST['game'];

        // photon forventer et parameter kaldet "args" med værdien.
        $data = [];
        $data['args'] = $game;

        // send post request og læs svar.
        $response = makePostRequest($url, $data);
    }

    if (isset($_POST['id1'])) {
        $id1 = $_POST['id1'];
		$data = [];
        $data['args'] = $id1;
		$response = makePostRequest($url, $data);
    }

    if (isset($_POST['id2'])) {
        $id2 = $_POST['id2'];
        $data = [];
        $data['args'] = $id2;
        $response = makePostRequest($url, $data);
    }

    if (isset($_POST['farve'])) {
        $farve = $_POST['farve'];
        $data = [];
        $data['args'] = $farve;
        $response = makePostRequest($url, $data);
    }

    if (isset($_POST['greb'])) {
        $greb = $_POST['greb'];
        $data = [];
        $data['args'] = $greb;
        $response = makePostRequest($url, $data);
    }
    ?>