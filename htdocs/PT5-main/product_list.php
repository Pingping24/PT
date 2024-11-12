<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product List</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include("menu.php"); // Menu inclusion
include("database.php"); // Include the database connection

// SQL query to fetch product data
$sql = "SELECT ProductID, ProductName, Price, OrderID FROM Product";
$result = $conn->query($sql);

echo "<a href='add.php?type=product' style='margin-left: 140px;: ;'>Add Product</a>";

echo "<table border='1' class='table'>
        <th colspan='5' style='text-align: center; font-size: 35px; background-color: white; color: black;'>Product List</th>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Order ID</th>
            <th width='210px'>Actions</th>
        </tr>";

// Check if there are results and display data
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["ProductID"] . "</td>
                <td>" . $row["ProductName"] . "</td>
                <td>" . $row["Price"] . "</td>
                <td>" . $row["OrderID"] . "</td>
                <td>
                    <a href='edit.php?id=" . $row["ProductID"] . "&type=product'>Edit</a>
                    <a href='delete.php?id=" . $row["ProductID"] . "&type=product' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No products found</td></tr>";
}

echo "</table>";

// Close the connection
$conn->close();
?>



</body>
</html>
