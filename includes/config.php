<?php
error_reporting(1);
//db connection settings
$host="localhost"; // Host name 
$username="root"; // Mysql username 
$password=""; // Mysql password 
$db_name="bbjewels"; // Database name

// ใช้ mysqli_connect แทน mysql_connect
$conn = mysqli_connect($host, $username, $password, $db_name);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>