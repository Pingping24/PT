<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Detail List</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include("menu.php"); // Menu inclusion
include("database.php"); // Include the database connection

// SQL query to fetch order detail data
$sql = "SELECT OrderDetailID, ProductID, Quantity, OrderID FROM OrderDetail";
$result = $conn->query($sql);

// HTML structure
echo "<h2 style='text-align: center; font-weight: bold;'>Order Detail List</h2>";
echo "<table border='1' class='table'>
        <tr>
            <th>Order Detail ID</th>
            <th>Product ID</th>
            <th>Quantity</th>
            <th>Order ID</th>
            <th width='210px'>Actions</th>
        </tr>";

// Check if there are results and display data
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["OrderDetailID"] . "</td>
                <td>" . $row["ProductID"] . "</td>
                <td>" . $row["Quantity"] . "</td>
                <td>" . $row["OrderID"] . "</td>
                <td>
                    <button><a href='edit.php?id=" . $row["OrderDetailID"] . "&type=order_detail'>Edit</a></button>
                    <button><a href='delete.php?id=" . $row["OrderDetailID"] . "&type=order_detail' onclick='return confirm(\"Are you sure you want to delete this order detail?\");'>Delete</a></button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No order details found</td></tr>";
}

echo "</table>";

// Close the connection
$conn->close();
?>

<button><a href='add.php?type=order_detail'>Add Order Detail</a></button>

</body>
</html>
