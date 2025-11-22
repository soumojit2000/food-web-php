<?php
require 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid ID!");
}

$id = (int)$_GET['id'];

// Fetch existing order
$sql = "SELECT * FROM food WHERE id=$id";
$res = mysqli_query($conn, $sql);

if (!$res || mysqli_num_rows($res) == 0) {
    die("Order not found!");
}

$old = mysqli_fetch_assoc($res);

// Update request
if (isset($_POST['update'])) {

    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $price       = max(0, intval($_POST['price']));
    $quantity    = max(0, intval($_POST['quantity']));
    $category    = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Default image remains old
    $img = $old['image'];

    // If new image uploaded
    if (!empty($_FILES['image']['name'])) {

        $orgName  = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $ext = strtolower(pathinfo($orgName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($ext, $allowed)) {

            // Ensure uploads folder exists
            if (!is_dir("uploads")) {
                mkdir("uploads");
            }

            // New image name
            $img = uniqid("img_") . "." . $ext;

            // Upload image
            move_uploaded_file($tmp_name, "uploads/" . $img);

            // Delete old image
            if (!empty($old['image']) && file_exists("uploads/" . $old['image'])) {
                unlink("uploads/" . $old['image']);
            }

        } else {
            echo "<p class='text-danger'>Invalid image type!</p>";
        }
    }

    // Update query
    $sql2 = "UPDATE food SET 
                name='$name',
                price='$price',
                quantity='$quantity',
                category='$category',
                description='$description',
                image='$img'
             WHERE id=$id";

    if (mysqli_query($conn, $sql2)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<p class='text-danger'>Update failed: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="px-5">

<h2 class="mt-4 mb-3">Edit Order</h2>

<form method="post" enctype="multipart/form-data">

    <label>Name</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($old['name']) ?>" required><br>

    <label>Price</label>
    <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($old['price']) ?>" required><br>

    <label>Quantity</label>
    <input type="number" name="quantity" class="form-control" value="<?= htmlspecialchars($old['quantity']) ?>" required><br>

    <label>Category</label>
    <select name="category" class="form-control">
        <option value="Breakfast" <?= $old['category']=="Breakfast" ? "selected" : "" ?>>Breakfast</option>
        <option value="Lunch" <?= $old['category']=="Lunch" ? "selected" : "" ?>>Lunch</option>
        <option value="Dinner" <?= $old['category']=="Dinner" ? "selected" : "" ?>>Dinner</option>
        <option value="Other" <?= $old['category']=="Other" ? "selected" : "" ?>>Other</option>
    </select><br>

    <label>Description</label>
    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($old['description']) ?></textarea><br>

    <label>Old Image:</label><br>
    <?php if (!empty($old['image']) && file_exists("uploads/" . $old['image'])): ?>
        <img src="uploads/<?= htmlspecialchars($old['image']) ?>" width="100" class="mb-3 rounded">
    <?php else: ?>
        <p class="text-danger">No image available</p>
    <?php endif; ?>

    <label>Upload New Image:</label>
    <input type="file" name="image" class="form-control mb-3">

    <button type="submit" name="update" class="btn btn-primary">Update</button>
    <a href="index.php" class="btn btn-success">Back</a>

</form>

</body>
</html>
