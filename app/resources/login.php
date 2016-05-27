<?php

  require_once('connection.php');


  // ---- RETREIVES VALUES FROM THE DATABASE


  // $sql = "SELECT * FROM user WHERE email = htmlspecialchars($_POST['data']['email'])";
  // $statement = $db->prepare($sql);
  //
  // $statement->execute();
  //
  // $result = $statement->fetchAll();

  // $result = htmlspecialchars($_POST['data']['email']);


  header('Content-type: application/json');
  echo json_encode($result);

?>
