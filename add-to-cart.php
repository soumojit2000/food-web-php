<?php
require 'config.php';

$pid = isset($_POST['pid']) ? (int)$_POST['pid'] : 0;
$qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;

// Check product exists
$sql = "SELECT * FROM food WHERE id=$pid AND status=1";
$res = mysqli_query($conn, $sql);

if(!$res || mysqli_num_rows($res) == 0){
    die("Invalid product!");
}

$product = mysqli_fetch_assoc($res);

// Check if item already in cart
$check = "SELECT id, quantity FROM cart WHERE product_id=$pid";
$resCheck = mysqli_query($conn, $check);

if(mysqli_num_rows($resCheck) > 0){
    $row = mysqli_fetch_assoc($resCheck);
    $newQty = $row['quantity'] + $qty;
    mysqli_query($conn, "UPDATE cart SET quantity=$newQty WHERE id={$row['id']}");
} else {
    $name = mysqli_real_escape_string($conn, $product['name']);
    $price = $product['price'];
    $image = $product['image'];

    mysqli_query($conn, 
        "INSERT INTO cart (product_id, name, price, quantity, image)
         VALUES ($pid, '$name', $price, $qty, '$image')"
    );
}

header("Location: cart.php");
exit();
?>
