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

// HTML structure
echo "<h2 style='text-align: center; font-weight: bold;'>Product List</h2>";
echo "<table border='1' class='table'>
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
                    <button><a href='edit.php?id=" . $row["ProductID"] . "&type=product'>Edit</a></button>
                    <button><a href='delete.php?id=" . $row["ProductID"] . "&type=product' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a></button>
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

<button><a href='add.php?type=product'>Add Product</a></button>

</body>
</html>
