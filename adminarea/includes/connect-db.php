<?php
error_reporting(1);

// Database Variables (edit with your own server information)
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'bbjewels';

// Connect to Database using mysqli
$connection = mysqli_connect($server, $user, $pass, $db);

// Check connection
if (!$connection) {
    die("Could not connect to server: " . mysqli_connect_error());
}
?>
