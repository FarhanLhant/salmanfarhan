<?php
$servername = "localhost";
$database = "uts";
$username = "root";
$password = "megamanx5@";

// Create connection

$link = mysqli_connect($servername, $username, $password, $database);

// Check connection

if ($link->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



//mysqli_close($link);

?>