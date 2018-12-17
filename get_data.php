<?php

extract($_GET);
include 'connect_to_db.php';
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT quarter,score FROM scores WHERE application='$app' AND organisation='$vertical' ORDER BY quarter;";
$result=$conn->query($sql);

$scores=[];
$labels=[];

if ($result->num_rows > 0) 
{
    while($row = $result->fetch_assoc()) 
    {
        $scores[]=$row['score'];
        $labels[]=$row['quarter'];
    }
}
$resp = array(
    "labels" => $labels,
    "scores" => $scores
    );

$myJSONString = json_encode($resp);
echo $myJSONString;
exit();
?>
