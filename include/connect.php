<?php 
$host = "localhost";
$userName = "root";
$password = "";
$dbName = "OrderRoom";

$db = new mysqli($host,$userName,$password,$dbName);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
} 
?>
