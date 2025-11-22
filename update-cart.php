<?php
require 'config.php';

$id = (int)$_POST['id'];
$qty = (int)$_POST['qty'];

mysqli_query($conn, "UPDATE cart SET quantity=$qty WHERE id=$id");

header("Location: cart.php");
exit();
?>
