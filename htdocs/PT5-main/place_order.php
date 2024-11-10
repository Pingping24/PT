<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
include("menu.php");
include("database.php");

// Fetch customer and product data
$customers = $conn->query("SELECT CustomerID, CustomerName FROM Customer");
$products = $conn->query("SELECT ProductID, ProductName, Price FROM Product");
?>

<h2>Place a New Order</h2>
<form action="submit_order.php" method="POST">
    <label for="customer">Customer:</label>
    <select name="customer_id" required>
        <?php while($customer = $customers->fetch_assoc()): ?>
            <option value="<?= $customer['CustomerID'] ?>"><?= $customer['CustomerName'] ?></option>
        <?php endwhile; ?>
    </select><br>

    <label for="product">Product:</label>
    <select name="product_id" required>
        <?php while($product = $products->fetch_assoc()): ?>
            <option value="<?= $product['ProductID'] ?>"><?= $product['ProductName'] ?> - $<?= $product['Price'] ?></option>
        <?php endwhile; ?>
    </select><br>

    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" min="1" required><br>

    <button type="submit">Place Order</button>
</form>

</body>
</html>
