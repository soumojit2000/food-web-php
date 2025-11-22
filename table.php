<?php
require 'config.php';

// SQL to create the food table
$sql = "CREATE TABLE IF NOT EXISTS food (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT UNSIGNED NOT NULL DEFAULT 1,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "<h2>Food Table Created Successfully!</h2>";
    echo "<p><a href='index.php'>Go to Active Orders</a></p>";
    echo "<p><a href='home.php'>Go to Home Page</a></p>";
} else {
    echo "<h3 style='color:red;'>Error Creating Table:</h3>";
    echo mysqli_error($conn);
}
?>
