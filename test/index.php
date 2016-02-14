<?php


$conn = mysqli_connect("127.0.0.1", 'root', 'beavis', "weather");
// $result = mysqli_query($conn, "SELECT cityname, zipcode FROM conditions");
$result = mysqli_query($conn, "SELECT cityname FROM conditions");
// while($row = mysqli_fetch_assoc($result)) {
//  $data[] = array($row[cityname] => $row[zipcode]);
//}
//mysqli_close($conn);
//header('Content-Type: application/json; charset=utf-8');
//print json_encode($data);

while ($row = mysqli_fetch_array($result)) {
   		echo "<option>" . $row{'cityname'} . "</option>";
	}
?>
