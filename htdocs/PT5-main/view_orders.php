<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include("menu.php"); // Include navigation menu
include("database.php"); // Include database connection

// SQL query to retrieve orders with product and customer details
$sql = "
    SELECT o.OrderID, c.CustomerName, o.OrderDate, p.ProductName, od.Quantity, p.Price, 
        (od.Quantity * p.Price) AS TotalAmount
    FROM `Order` o
    JOIN OrderDetail od ON o.OrderID = od.OrderID
    JOIN Customer c ON o.CustomerID = c.CustomerID
    JOIN Product p ON od.ProductID = p.ProductID
    ORDER BY o.OrderDate DESC
";
$result = $conn->query($sql);

// Display the orders
echo "<h2 style='text-align: center; font-weight: bold;'>Order List</h2>";
echo "<table border='1' class='table'>
    <tr>
        <th>Order ID</th>
        <th>Customer Name</th>
        <th>Order Date</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price per Unit</th>
        <th>Total Amount</th>
    </tr>";

if ($result->num_rows > 0) {
    // Loop through each order and display details
    while($row = $result->fetch_assoc()) {
        $formatted_total_amount = number_format($row['TotalAmount'], 2, ); // Format with 2 decimal places and commas
        echo "<tr>
            <td>{$row['OrderID']}</td>
            <td>{$row['CustomerName']}</td>
            <td>{$row['OrderDate']}</td>
            <td>{$row['ProductName']}</td>
            <td>{$row['Quantity']}</td>
            <td>₱{$row['Price']}</td>
            <td>₱$formatted_total_amount</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='7'>No orders found</td></tr>";
}

echo "</table>";

// Close the database connection
$conn->close();
?>

</body>
</html>