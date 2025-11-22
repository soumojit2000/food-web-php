<?php
require 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<p style='color:red;'>Invalid Request!</p>");
}

$id = (int)$_GET['id'];

// Check if product exists in trash
$sqlCheck = "SELECT * FROM food WHERE id = $id AND status = 0";
$resCheck = mysqli_query($conn, $sqlCheck);

if (!$resCheck || mysqli_num_rows($resCheck) == 0) {
    die("<p style='color:red;'>Product not found in trash!</p>");
}

// Restore → set status = 1
$sqlRestore = "UPDATE food SET status = 1 WHERE id = $id";

if (mysqli_query($conn, $sqlRestore)) {
    // Return back to trash page
    header("Location: trash.php");
    exit();
} else {
    echo "<p style='color:red;'>Restore Failed: " . mysqli_error($conn) . "</p>";
}
?>
