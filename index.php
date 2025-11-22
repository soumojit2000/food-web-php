<?php
require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Orders</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        table img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 5px;
        }
        table {
            background: white;
        }
        h2 {
            margin-top: 20px;
        }
    </style>
</head>
<body class="container py-4">

    <h2>All Available Didhes:</h2>

    <p>
        <a href="add.php" class="btn btn-primary btn-sm">Add New Order</a>
        <a href="trash.php" class="btn btn-danger btn-sm">Soft deleted orders</a>
        <a href="home.php" class="btn btn-success btn-sm">Back to Home</a>
    </p>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>PRICE</th>
                    <th>QUANTITY</th>
                    <th>CATEGORY</th>
                    <th>IMAGE</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $sql = "SELECT * FROM food WHERE status = 1 ORDER BY id ASC";
                $res = mysqli_query($conn, $sql);

                if ($res && mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {

                        // Image Handling
                        $img = $row['image'];
                        if (!empty($img) && file_exists("uploads/" . $img)) {
                            $imgPath = "uploads/" . $img;
                        } else {
                            $imgPath = ""; // No image available
                        }

                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>₹" . htmlspecialchars($row['price']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['category']) . "</td>";

                        echo "<td>";
                        echo $imgPath ? "<img src='$imgPath'>" : "No Image";
                        echo "</td>";

                        echo "<td>
                                <a class='btn btn-sm btn-warning' href='edit.php?id={$row['id']}'>Edit</a>
                                <a class='btn btn-sm btn-secondary' href='soft-delete.php?id={$row['id']}' onclick=\"return confirm('Move to trash?')\">Soft Delete</a>
                                <a class='btn btn-sm btn-danger' href='delete.php?id={$row['id']}' onclick=\"return confirm('Permanently delete? This cannot be undone')\">Delete</a>
                              </td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr>
                            <td colspan='7' class='text-danger fw-bold'>
                                No active orders found!
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
