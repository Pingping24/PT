<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Entity</title>
<style>
    body {
        background-color: #f8f9fa; /* Light background color for better readability */
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 400px; /* Increased width for better layout */
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333; /* Darker color for contrast */
    }

    label {
        margin-bottom: 5px;
        display: block;
        font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #007bff; /* Primary button color */
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #0056b3; /* Darker shade for hover effect */
    }
</style>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include("database.php"); // Include your database connection

// Check if the type parameter is set
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    // Removed the echo statement displaying the type parameter
    // echo "Type parameter: " . htmlspecialchars($type); // Debugging output
} else {
    die("Invalid request.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and execute query based on the entity type
    switch ($type) {
        case 'customer':
            $customerName = $_POST['customerName'];
            $phoneNumber = $_POST['phoneNumber'];
            $deliveryAddress = $_POST['deliveryAddress'];

            $sql = "INSERT INTO Customer (CustomerName, PhoneNumber, DeliveryAddress) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $customerName, $phoneNumber, $deliveryAddress);
            break;

        case 'order':
            $customerID = $_POST['customerID'];
            $orderDate = $_POST['orderDate'];

            $sql = "INSERT INTO `Order` (CustomerID, OrderDate) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $customerID, $orderDate);
            break;

        case 'product':
            $productName = $_POST['productName'];
            $price = $_POST['price'];
            $orderID = $_POST['orderID'];

            $sql = "INSERT INTO Product (ProductName, Price, OrderID) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdi", $productName, $price, $orderID);
            break;

        case 'order_detail':
            $productID = $_POST['productID'];
            $quantity = $_POST['quantity'];
            $orderID = $_POST['orderID'];

            $sql = "INSERT INTO OrderDetail (ProductID, Quantity, OrderID) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $productID, $quantity, $orderID);
            break;

        default:
            die("Invalid type specified.");
    }

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "<script>
        alert('Record added successfully!');
window.location.href = 'customer_list.php?type=" . $type . "';
window.location.href = 'order_list.php?type=" . $type . "';
        </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<div class="container">
<h2 style="text-align: center; font-weight: bold;">Add <?php echo ucfirst($type); ?></h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?type=' . urlencode($type); ?>">
    <?php if ($type === 'customer'): ?>
        <label for="customerName">Customer Name:</label>
        <input type="text" name="customerName" required><br>

        <label for="phoneNumber">Phone Number:</label>
        <input type="text" name="phoneNumber" required><br>

        <label for="deliveryAddress">Delivery Address:</label>
        <input type="text" name="deliveryAddress" required><br>

    <?php elseif ($type === 'order'): ?>
        <label for="customerID">Customer ID:</label>
        <input type="number" name="customerID" required><br>

        <label for="orderDate">Order Date:</label>
        <input type="date" name="orderDate" required><br>

    <?php elseif ($type === 'product'): ?>
        <label for="productName">Product Name:</label>
        <input type="text" name="productName" required><br>

        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" required><br>

        <label for="orderID">Order ID:</label>
        <input type="number" name="orderID" required><br>

    <?php elseif ($type === 'order_detail'): ?>
        <label for="productID">Product ID:</label>
        <input type="number" name="productID" required><br>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required><br>

        <label for="orderID">Order ID:</label>
        <input type="number" name="orderID" required><br>
    <?php endif; ?>

    <input type="submit" value="Add">
</form>

<?php $conn->close(); ?>

</body>
</html>
