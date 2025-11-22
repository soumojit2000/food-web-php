<?php
require 'config.php';

$sql = "CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "<h3>Cart table created successfully!</h3>";
    echo "<a href='home.php'>Go to Home Page</a>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
