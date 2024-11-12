<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order List</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include("menu.php"); // Menu inclusion
include("database.php"); // Include the database connection

// SQL query to fetch order data
$sql = "SELECT OrderID, CustomerID, OrderDate FROM `Order`";
$result = $conn->query($sql);

// HTML structure
echo "<h2 style='text-align: center; font-weight: bold;'>Order List</h2>";
echo "<table border='1' class='table'>
        <tr>
            <th>Order ID</th>
            <th>Customer ID</th>
            <th>Order Date</th>
            <th width='210px'>Actions</th>
        </tr>";

// Check if there are results and display data
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["OrderID"] . "</td>
                <td>" . $row["CustomerID"] . "</td>
                <td>" . $row["OrderDate"] . "</td>
                <td>
                    <button><a href='edit.php?id=" . $row["OrderID"] . "&type=order'>Edit</a></button>
                    <button><a href='delete.php?id=" . $row["OrderID"] . "&type=order' onclick='return confirm(\"Are you sure you want to delete this order?\");'>Delete</a></button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No orders found</td></tr>";
}

echo "</table>";

// Close the connection
$conn->close();
?>

<button><a href='add.php?type=order'>Add Order</a></button>

</body>
</html>
