<?php
require_once("dbconnection.php");
require_once("index.php");

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