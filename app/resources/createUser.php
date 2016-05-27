<?php

  require_once('connection.php');

  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  $name = $request->name;
  $email = $request->email;
  $password = $request->password;
  $picture = "http://boulder.pixelab.dk/img/avatar.png";


  $insert_sql = "INSERT INTO user(name, email, password, picture) VALUES (:name, :email, :password, :picture)";
  $insert_statement = $db->prepare($insert_sql);

  $insert_statement->bindValue(':name', $name);
  $insert_statement->bindValue(':email', $email);
  $insert_statement->bindValue(':password', $password);
  $insert_statement->bindValue(':picture', $picture);

  // Undersøger om der allerede er en bruger med den email
  $search_sql = "SELECT * FROM user WHERE email = '" . $email . "'";
  $search_statement = $db->prepare($search_sql);

  $search_statement->execute();

  $result = $search_statement->fetchAll();


  if($result == null){
    // Hvis ingen bruger har den email - oprettes brugeren
    $insert_statement->execute();
    echo "Succes";
  }
  else{
    echo "Email_invalid";
  }


?>
