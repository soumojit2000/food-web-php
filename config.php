<?php

$server = "localhost";
$user = "root";
$pass = "";
$db_name = "food_db";

// 1. Connect to server
$conn = mysqli_connect($server, $user, $pass);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 2. Create database if not exists (only once)
$sql = "CREATE DATABASE IF NOT EXISTS $db_name";
mysqli_query($conn, $sql);

// 3. Connect to the database
$conn = mysqli_connect($server, $user, $pass, $db_name);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
