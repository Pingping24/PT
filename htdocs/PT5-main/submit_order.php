<?php
include("database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch product price
    $result = $conn->query("SELECT Price FROM Product WHERE ProductID = $product_id");
    $product = $result->fetch_assoc();
    $total_price = $product['Price'] * $quantity;

    // Insert into Order table
    $conn->query("INSERT INTO `Order` (CustomerID, OrderDate) VALUES ($customer_id, NOW())");
    $order_id = $conn->insert_id;

    // Insert into OrderDetail table
    $conn->query("INSERT INTO OrderDetail (OrderID, ProductID, Quantity) VALUES ($order_id, $product_id, $quantity)");

    echo "Order placed successfully! <a href='view_orders.php'>View Orders</a>";
} else {
    echo "Invalid request.";
}

$conn->close();
?>
