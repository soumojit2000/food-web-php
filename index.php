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

        h2 {
            margin-top: 20px;
            text-align: center;
        }

        @media(max-width:767px){

           
            table thead {
                display: none;
            }

            table, table tbody, table tr, table td {
                display: block;
                width: 100%;
            }

            table tr {
                background: white;
                margin-bottom: 15px;
                padding: 10px;
                border-radius: 10px;
                border: 1px solid #ccc;
            }

            table td {
                text-align: left !important;
                padding: 6px 8px;
                border: none !important;
                border-bottom: 1px solid #eee !important;
            }

            /* Label before each value */
            table td:before {
                content: attr(data-label);
                font-weight: bold;
                width: 100%;
                display: block;
                color: #000;
                margin-bottom: 3px;
            }

            
            table img {
                width: 100%;
                height: auto;
                margin: 10px 0;
                border-radius: 8px;
            }

            
            .action-btns {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .action-btns a {
                width: 100%;
                text-align: center;
            }
        }

    </style>
</head>
<body class="container py-4">

    <h2>All Available Dishes:</h2>

    <div class="d-flex flex-wrap gap-2 mb-3">
        <a href="add.php" class="btn btn-primary btn-sm">Add New Order</a>
        <a href="trash.php" class="btn btn-danger btn-sm">Soft Deleted Orders</a>
        <a href="home.php" class="btn btn-success btn-sm">Back to Home</a>
    </div>

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

                        $img = $row['image'];
                        $imgPath = (!empty($img) && file_exists("uploads/" . $img)) ? "uploads/" . $img : "";

                        echo "<tr>";

                        echo "<td data-label='ID'>{$row['id']}</td>";
                        echo "<td data-label='Name'>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td data-label='Price'>₹" . htmlspecialchars($row['price']) . "</td>";
                        echo "<td data-label='Quantity'>" . htmlspecialchars($row['quantity']) . "</td>";
                        echo "<td data-label='Category'>" . htmlspecialchars($row['category']) . "</td>";

                        echo "<td data-label='Image'>";
                        echo $imgPath ? "<img src='$imgPath'>" : "No Image";
                        echo "</td>";

                        echo "<td data-label='Actions'>
                                <div class='action-btns d-flex flex-column flex-md-row justify-content-center gap-2'>
                                    <a class='btn btn-sm btn-warning' href='edit.php?id={$row['id']}'>Edit</a>
                                    <a class='btn btn-sm btn-secondary' href='soft-delete.php?id={$row['id']}' onclick=\"return confirm('Move to trash?')\">Soft Delete</a>
                                    <a class='btn btn-sm btn-danger' href='delete.php?id={$row['id']}' onclick=\"return confirm('Permanently delete? This cannot be undone')\">Delete</a>
                                </div>
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
