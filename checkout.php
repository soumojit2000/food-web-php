<?php
require 'config.php';

// Step 1: Fetch all cart items
$sql = "SELECT * FROM cart ORDER BY id ASC";
$res = mysqli_query($conn, $sql);

$cartItems = [];
$grandTotal = 0;

if ($res && mysqli_num_rows($res) > 0) {
    while ($item = mysqli_fetch_assoc($res)) {
        $cartItems[] = $item;
        $grandTotal += $item['price'] * $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<h2>Checkout</h2>

<?php
/* ===========================================
   Step 2: Handle Checkout Button
=========================================== */
if (isset($_POST['checkout'])) {

    if (!empty($cartItems)) {

        foreach ($cartItems as $item) {

            $pid  = $item['product_id'];
            $name = mysqli_real_escape_string($conn, $item['name']);
            $price = $item['price'];
            $qty   = $item['quantity'];
            $img   = $item['image'];

            // Get stock from food table
            $sqlStock = "SELECT quantity FROM food WHERE id = $pid AND status=1";
            $resStock = mysqli_query($conn, $sqlStock);

            if ($resStock && mysqli_num_rows($resStock) > 0) {
                $prod = mysqli_fetch_assoc($resStock);
                $stock = (int)$prod['quantity'];

                // If cart qty > stock → block checkout
                if ($qty > $stock) {
                    echo "<div class='alert alert-danger'>
                            Stock too low for $name. Available: $stock
                          </div>";
                    echo "<a href='cart.php' class='btn btn-warning'>Back to Cart</a>";
                    exit;
                }

                // Deduct stock
                $newStock = $stock - $qty;
                mysqli_query($conn, "UPDATE food SET quantity=$newStock WHERE id=$pid");
            }

            
        }

        // Empty cart
        mysqli_query($conn, "DELETE FROM cart");

        echo "<div class='alert alert-success'>Order placed successfully!</div>";
        echo "<a href='order.php?cat=All' class='btn btn-primary'>Back to Shop</a>";
        exit;

    } else {
        echo "<div class='alert alert-danger'>Your cart is empty! Cannot checkout.</div>";
    }
}
?>

<?php if (empty($cartItems)): ?>
    <div class="alert alert-warning">Your cart is empty!</div>
    <a href="order.php?cat=All" class="btn btn-primary">Back to Shop</a>

<?php else: ?>

<table class="table table-bordered text-center">
<thead class="table-dark">
<tr>
<th>Name</th>
<th>Price</th>
<th>Qty</th>
<th>Total</th>
</tr>
</thead>
<tbody>

<?php foreach ($cartItems as $item): ?>
<?php $total = $item['price'] * $item['quantity']; ?>

<tr>
<td><?= htmlspecialchars($item['name']) ?></td>
<td>₹<?= $item['price'] ?></td>
<td><?= $item['quantity'] ?></td>
<td>₹<?= $total ?></td>
</tr>

<?php endforeach; ?>

<tr class="table-success">
<td colspan="3"><strong>Grand Total</strong></td>
<td><strong>₹<?= $grandTotal ?></strong></td>
</tr>

</tbody>
</table>

<form method="POST">
<button type="submit" name="checkout" class="btn btn-success">Place Order</button>
</form>

<?php endif; ?>

</body>
</html>
