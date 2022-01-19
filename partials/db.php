<?php
// Script to connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "bst";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn){
    die("Error". mysqli_connect_error());
}
?>
