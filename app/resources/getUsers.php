<?php

  require_once('connection.php');


  // ---- RETREIVES VALUES FROM THE DATABASE

  if (isset($_GET['user_id'])) {

    // $sql = "SELECT * FROM light ORDER BY light_value DESC";
    $sql = "SELECT * FROM user WHERE id = " . $_GET['user_id'];
    $statement = $db->prepare($sql);

    $statement->execute();

    $result = $statement->fetchAll();

    header('Content-type: application/json');
    echo json_encode($result);
  }
  else if (isset($_GET['email'])) {

    // $sql = "SELECT * FROM light ORDER BY light_value DESC";
    $sql = "SELECT * FROM user WHERE email = '" . $_GET['email'] . "'";
    $statement = $db->prepare($sql);

    $statement->execute();

    $result = $statement->fetchAll();

    header('Content-type: application/json');
    echo json_encode($result);

  }
  else{

    // $sql = "SELECT * FROM light ORDER BY light_value DESC";
    $sql = "SELECT * FROM user";
    $statement = $db->prepare($sql);

    $statement->execute();

    $result = $statement->fetchAll();

    header('Content-type: application/json');
    echo json_encode($result);
  }




?>
