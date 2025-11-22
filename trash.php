<?php
require 'config.php';

// Fetch only soft deleted products (status = 0)
$sql = "SELECT * FROM food WHERE status = 0 ORDER BY id DESC";
$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trash Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="mb-4">Soft Deleted Orders</h2>

    <a href="index.php" class="btn btn-primary mb-3">
        ← Back to Active Products
    </a>

    <table class="table table-striped table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Restore</th>
                <th>Permanent Delete</th>
            </tr>
        </thead>

        <tbody>
        <?php if (mysqli_num_rows($res) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($res)) { ?>

                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>

                    <td>
                        <?php 
                        $img = $row['image'];
                        if (!empty($img) && file_exists("uploads/" . $img)) {
                            echo "<img src='uploads/$img' width='70' height='70' class='rounded'>";
                        } else {
                            echo "No Image";
                        }
                        ?>
                    </td>

                    <td>
                        <a href="restore.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">
                            Restore
                        </a>
                    </td>

                    <td>
                        <a href="delete.php?id=<?= $row['id'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('This will permanently delete the product. Continue?');">
                            Delete Forever
                        </a>
                    </td>
                </tr>

            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="5">
                    <div class="alert alert-warning fw-bold m-0">
                        No deleted products found.
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>

    </table>

</body>
</html>
