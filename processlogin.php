<?php
session_start();
include "includes/connection.php";

$form_user = $_POST['txtusername'];
$form_password = $_POST['txtpassword'];

if ($form_user == "" || $form_password == "") {
    echo '<script>alert("Please Fill up all fields!");</script>';
    echo "<script>window.location.href='default.php';</script>";
    exit;
}

// เปิดการเชื่อมต่อ DB
$dbconnect = new DbConnect();
$dbconnect->open();

// ป้องกัน SQL Injection (ขั้นพื้นฐาน)
$form_user = $dbconnect->conn->real_escape_string($form_user);
$form_password = $dbconnect->conn->real_escape_string($form_password);

// สร้าง SQL
$sql = "SELECT user_id, username, password, ac_type, user_status 
        FROM users 
        WHERE username = '$form_user' AND password = '$form_password'";

// ใช้งาน DbQuery
$dbquery = new DbQuery($dbconnect, $sql);
$result = $dbquery->query();
$numrecs = $dbquery->numrows();

if ($numrecs > 0) {
    while ($row = $dbquery->fetcharray()) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $pass = $row['password'];
        $ac_type = $row['ac_type'];
        $status = $row['user_status'];

        if ($status == "0" && $ac_type == "Administrator") {
            $_SESSION['status'] = "admin";
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id;
            echo "<script>alert('Welcome Back Webmaster. Redirecting to personal home page.');</script>";
            echo "<script>window.location.href='adminarea/adminhome.php';</script>";
            exit;
        } else if ($status == "1" && $ac_type == "user") {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id;
            echo "<script>alert('Welcome Back');</script>";
            echo "<script>window.location.href='index-1.php';</script>";
            exit;
        } else {
            echo "<script>window.location.href='index-1.php';</script>";
            exit;
        }
    }
} else {
    echo '<script>alert("Username and/or password not found! \n\n Signup or Login again");</script>';
    session_unset();
    session_destroy();
    echo "<script>window.location.href='default.php';</script>";
}

$dbquery->freeresult();
$dbquery->close();
?>
