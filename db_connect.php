<?php
// before running, this credentials should be modified specific to user and database 
$username = "";
$password = "";
$db_name = "";
$host_name= "dijkstra.ug.bcc.bilkent.edu.tr";

// create connection
$db = new mysqli($host_name, $username, $password, $db_name);

// check connection
if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
} 
?>