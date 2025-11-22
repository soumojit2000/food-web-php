<?php
require 'config.php';

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<p style='color:red;'>Invalid Request!</p>");
}

$id = (int)$_GET['id'];

// Check if product exists and is active
$checkSql = "SELECT * FROM food WHERE id = $id AND status = 1";
$checkRes = mysqli_query($conn, $checkSql);

if (!$checkRes || mysqli_num_rows($checkRes) == 0) {
    die("<p style='color:red;'>Product does not exist or is already deleted!</p>");
}

// Soft Delete → status = 0
$sql = "UPDATE food SET status = 0 WHERE id = $id";
$res = mysqli_query($conn, $sql);

if ($res) {
    header("Location: trash.php");
    exit();
} else {
    echo "<p style='color:red;'>Soft Delete Failed: " . mysqli_error($conn) . "</p>";
}
?>
