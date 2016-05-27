<?php
require_once("select.php");

// device info
$deviceID = "370045000f47343432313031";
$accessToken = "f63e306281c4828b0c212c2498268fb63272dc83";
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
?>

<?php
require_once("dbconnection.php");

$tid2 = $json->result;
$greb2 = $json2->result;
$success2 = $json3->result;

header("refresh:6");

if($success2==true){
// this sql statement contains a placeholder for the variables
$sql = "INSERT INTO pointtavle(tid, greb)
VALUES (:tid, :greb)";

$statement = $db->prepare($sql);

// bind values to the SQL statement
$statement->bindValue(':tid', $tid2);
$statement->bindValue(':greb', $greb2);

// execute the sql statement
$statement->execute();
}

?>