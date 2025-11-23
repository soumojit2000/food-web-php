<?php
require 'config.php';

$sql = "SELECT * FROM cart ORDER BY id ASC";
$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Cart</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">

<h2>My Cart</h2>
<a href="order.php?cat=All" class="btn btn-primary btn-sm mb-3">Continue Shopping</a>

<?php if(mysqli_num_rows($res) > 0){ ?>
<table class="table table-bordered text-center">
    <thead class="table-dark">
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php 
        $grand = 0;
        while($row = mysqli_fetch_assoc($res)){
        $total = $row['price'] * $row['quantity'];
        $grand += $total;
        ?>
        <tr>
            <td><?= $row['image'] ? "<img src='uploads/{$row['image']}' width='70'>" : "No Image"; ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td>₹<?= $row['price'] ?></td>

            <td>
                <form action="update-cart.php" method="POST" class="d-flex justify-content-center">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="number" name="qty" min="1" value="<?= $row['quantity'] ?>" class="form-control w-50 me-2">
                    <button class="btn btn-sm btn-primary">Update</button>
                </form>
            </td>

            <td>₹<?= $total ?></td>

            <td>
                <a href="remove-from-cart.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Remove</a>
            </td>
        </tr>
        <?php } ?>

        <tr class="table-success">
            <td colspan="4" class="text-end"><b>Grand Total:</b></td>
            <td colspan="2"><b>₹<?= $grand ?></b></td>
        </tr>
    </tbody>
</table>

<a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
<?php } else { ?>
<div class="alert alert-warning">Your cart is empty!</div>
<?php } ?>

</body>
</html>
