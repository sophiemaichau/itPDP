<?php
  require_once('lightcontrol.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Light Controller</title>
  </head>
  <body>

    <ul>
      <?php
        foreach($result as $row){
          echo "<li>";
          echo $row['timestamp'] . " : " . $row['sensor_name'] . " | Value: " . $row['light_value'];
          echo "</li>";
        }
      ?>
    </ul>

  </body>
</html>
