<?php
require 'config.php';
mysqli_query($conn, "DROP TABLE IF EXISTS cart");
mysqli_query($conn, "DROP TABLE IF EXISTS food");
echo "Old tables deleted!";
?>
