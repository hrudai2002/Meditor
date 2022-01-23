<?php 

$serverName = "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbName = "login-system";
// $serverName = "localhost";
// $dbUserName = "id18295308_root";
// $dbPassword = "px08sn%K0sXT[Q-H";
// $dbName = "id18295308_loginsystem";

// $serverName = "localhost";
// $dbUserName = "	epiz_30833759";
// $dbPassword = "A5XUwsnpPX";
// $dbName = "epiz_30833759_meditor";

$conn = mysqli_connect($serverName, $dbUserName, $dbPassword, $dbName);

if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}