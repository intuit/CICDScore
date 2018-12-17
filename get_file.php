<?php
extract($_GET);
if(isset($vertical))
{
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "cicdscore";
	$conn = new \MySQLi($servername, $username, $password, $dbname) or die(mysqli_error());
	$sql = "SELECT application from all_apps WHERE organisation = '".$vertical."' ";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$temp = '"'.$row["application"].'"';
		$apps = $apps . trim($temp, '"') . ";";
	}
	echo $apps;
}
?>
