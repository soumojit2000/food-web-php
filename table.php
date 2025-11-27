<?php
require 'config.php';

echo "<h2>Table Setup:</h2>";

/* ==============================
   1) FOOD TABLE
============================== */

$sql1 = "CREATE TABLE IF NOT EXISTS food (
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

if (mysqli_query($conn, $sql1)) {
    echo "food table created!<br>";
} else {
    echo "food table failed: ".mysqli_error($conn)."<br>";
}

// Step B: CREATE users table
$sql2 = "CREATE TABLE IF NOT EXISTS users_food(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    UNIQUE (email)
)";

if(mysqli_query($conn, $sql2)){
    echo "users_food table created successfully!<br>";
} else {
    echo "users_food creation failed: " . mysqli_error($conn) . "<br>";
}

//step C: create cart-table:

$sql3 = "CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql3)) {
    echo "Cart table created successfully!<br>";
    
} else {
    echo "Error: " . mysqli_error($conn);
}
echo "<br><a href='login.php'>Go to Login Page</a>";
?>
