<?php
// DB connection settings
$host = "localhost";        // Host name 
$username = "root";         // MySQL username 
$password = "";             // MySQL password 
$db_name = "bbjewels";      // Database name

// เชื่อมต่อฐานข้อมูลพร้อมชื่อ DB
$conn = mysqli_connect($host, $username, $password, $db_name);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
