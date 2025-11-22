<?php
include "config.php";

// Step 1: Get category from URL (optional)
$category = isset($_GET['cat']) ? $_GET['cat'] : "";

// If no category OR "All" → show all active products
if ($category == "" || $category == "All") {
    $sql = "SELECT * FROM food WHERE status=1 ORDER BY id ASC";
} 
// Otherwise → show specific category
else {
    $category = mysqli_real_escape_string($conn, $category);
    $sql = "SELECT * FROM food WHERE category='$category' AND status=1 ORDER BY id ASC";
}

$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .food-card img{
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }
        .food-card{
            transition: .2s;
        }
        .food-card:hover{
            transform: translateY(-4px);
            box-shadow: 0 4px 15px rgba(0,0,0,.2);
        }
    </style>
</head>

<body class="bg-light">

<div class="container py-4">

    <h2 class="mb-3">
        Order Page 
        <?php 
        // Show category name only if specific category selected
        if ($category != "" && $category != "All") {
            echo "<span class='text-primary'> - " . htmlspecialchars($category) . "</span>";
        }
        ?>
    </h2>

    <!-- Top Buttons -->
    <div class="mb-4">
        <a href="index.php" class="btn btn-success btn-sm">Active Orders</a>
        <a href="order.php?cat=All" class="btn btn-warning btn-sm">All Products</a>
        <a href="add.php" class="btn btn-primary btn-sm">Add New Order</a>
        <a href="home.php" class="btn btn-dark">Back to home</a>
    </div>

    <div class="row">

        <?php
        // If products exist
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
        ?>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card food-card p-2">
                
                <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="Food Image">

                <div class="card-body text-center">
                    <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>

                    <p class="mb-1">Price: <strong>₹<?= $row['price'] ?></strong></p>
                    <p class="mb-2">Qty in Stock: <strong><?= $row['quantity'] ?></strong></p>

                    <!-- Add to cart form -->
                    <form action="add-to-cart.php" method="POST">
                        <input type="hidden" name="pid" value="<?= $row['id'] ?>">

                        <label class="form-label">Quantity</label>
                        <input type="number" name="qty" min="1" value="1" class="form-control mb-2">

                        <button type="submit" class="btn btn-primary w-100">
                            Add to Cart
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <?php
            }
        } else {
            // If no product found
            echo "<div class='alert alert-danger'>No products found in this category.</div>";
        }
        ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
