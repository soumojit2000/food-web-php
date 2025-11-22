<?php
require 'config.php';

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = intval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $img = "";  // Default image empty

    /* =============================
        File Upload Handling
    ============================== */
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

        $orgName = basename($_FILES['image']['name']);
        $tempName = $_FILES['image']['tmp_name'];

        $ext = strtolower(pathinfo($orgName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($ext, $allowed)) {

            // Create uploads folder if not exist
            if (!is_dir("uploads")) {
                mkdir("uploads");
            }

            // Unique name
            $img = uniqid("img_") . "." . $ext;

            move_uploaded_file($tempName, "uploads/" . $img);

        } else {
            die("Only JPG, JPEG, PNG, GIF, WEBP allowed!");
        }
    }

    /* =============================
        Insert Query
    ============================== */

    $sql = "INSERT INTO food (name, price, quantity, category, description, image)
            VALUES ('$name', '$price', '$quantity', '$category', '$description', '$img')";

    $res = mysqli_query($conn, $sql);

    if (!$res) {
        die("Insertion failed: " . mysqli_error($conn));
    } else {
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Order</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

    <h2>Add New Order</h2>

    <form method="post" enctype="multipart/form-data">

        <label>Name:</label>
        <input type="text" name="name" class="form-control" required><br>

        <label>Price:</label>
        <input type="number" name="price" class="form-control" required><br>

        <label>Quantity:</label>
        <input type="number" name="quantity" class="form-control" required><br>

        <label>Category:</label>
        <select name="category" class="form-control">
            <option value="Breakfast">Breakfast</option>
            <option value="Lunch">Lunch</option>
            <option value="Dinner">Dinner</option>
            <option value="Other">Other</option>
        </select><br>

        <label>Description:</label>
        <textarea name="description" class="form-control" required></textarea><br>

        <label>Image:</label>
        <input type="file" name="image" class="form-control" required><br>

        <input type="submit" value="Add" name="submit" class="btn btn-primary">
    </form>

</body>
</html>
