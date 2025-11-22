<?php
require 'config.php';

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<p style='color:red;'>Invalid Request!</p>");
}

$id = (int)$_GET['id'];

// Get image before deleting
$sql1 = "SELECT image FROM food WHERE id = $id LIMIT 1";
$result = mysqli_query($conn, $sql1);

if (!$result || mysqli_num_rows($result) == 0) {
    die("<p style='color:red;'>Product not found!</p>");
}

$data = mysqli_fetch_assoc($result);

// Delete product from DB
$sql2 = "DELETE FROM food WHERE id = $id";
$res = mysqli_query($conn, $sql2);

if ($res) {

    // Delete image from uploads folder
    if (!empty($data['image'])) {
        $imgPath = "uploads/" . $data['image'];

        if (file_exists($imgPath)) {
            unlink($imgPath);
        }
    }

    // Redirect back to trash page (better UX)
    header("Location: trash.php");
    exit();

} else {
    echo "<p style='color:red;'>Delete Failed: " . mysqli_error($conn) . "</p>";
}
?>
