<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
    <link rel="stylesheet" href="style.css">
    <style>
h2 {
    color: #333;
    text-align: center;
}

.container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    max-width: 320px;
    margin: 20px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

label {
    width: 100px;
    font-weight: bold;
}

select, input[type="number"] {
    flex: 1; /* Make input field take remaining space */
    padding: 5px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

button {
    background-color: #4CAF50;
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
}

button:hover {
    background-color: #ddd;
}
</style>
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
<form action="submit_order.php" method="POST" class="container">
    <div class="form-group">
        <label for="customer">Customer:</label>
        <select name="customer_id" required>
            <?php while($customer = $customers->fetch_assoc()): ?>
                <option value="<?= $customer['CustomerID'] ?>"><?= $customer['CustomerName'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="product">Product:</label>
        <select name="product_id" required>
            <?php while($product = $products->fetch_assoc()): ?>
                <option value="<?= $product['ProductID'] ?>"><?= $product['ProductName'] ?> - $<?= $product['Price'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" min="1" required>
    </div>

    <button type="submit">Place Order</button>
</form>



</body>
</html>
