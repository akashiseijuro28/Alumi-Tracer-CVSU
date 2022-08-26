<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "cvsu_imus_alumnitracker";

$con = mysqli_connect($server, $username, $password, $database);

if (!$con){
	die("<script>alert('Database Connection Failed.')</script>");
}


?>