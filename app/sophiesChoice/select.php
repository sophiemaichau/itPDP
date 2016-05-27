<?php
require_once("dbconnection.php");
require_once("index.php");

$sql = "SELECT * FROM pointtavle";
		
$statement = $db->prepare($sql);

// execute the sql statement
$statement->execute();

// get the result in array format.
$results = $statement->fetchAll();

?>
<h2>Point tavle</h2>
<table style="width:100%">
  <tr>
    <td><b>Runde</b></td>
    <td><b>Tid</b></td> 
    <td><b>Antal greb</b></td>
  </tr>
<?php
foreach ($results as $row) {
	echo "<tr>";
    echo "<td>";
    echo $row['runde'];
    echo "</td>";
    echo "<td>";
    echo $row['tid'];
    echo "</td>";
    echo "<td>";
    echo $row['greb'];
    echo "</td>";
    echo "</tr>";
}
?>
</table>
</ul>