<?php
include("database.php"); // Include the database connection

// Check if the ID and type are provided
if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    // Define SQL queries based on the type
    switch ($type) {
        case 'customer':
            $sql = "SELECT CustomerID, CustomerName, PhoneNumber, DeliveryAddress FROM Customer WHERE CustomerID = $id";
            break;
        case 'order':
            $sql = "SELECT OrderID, CustomerID, OrderDate FROM `Order` WHERE OrderID = $id";
            break;
        case 'product':
            $sql = "SELECT ProductID, ProductName, Price, OrderID FROM Product WHERE ProductID = $id";
            break;
        case 'order_detail':
            $sql = "SELECT OrderDetailID, ProductID, Quantity, OrderID FROM OrderDetail WHERE OrderDetailID = $id";
            break;
        default:
            echo "Invalid type.";
            exit;
    }

    // Run the query
    $result = $conn->query($sql);

    // Check if we got a result
    if ($result->num_rows == 1) {
        $item = $result->fetch_assoc(); // Fetch data
    } else {
        echo "Record not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update based on the type
    switch ($type) {
        case 'customer':
            $customerName = $_POST['CustomerName'];
            $phoneNumber = $_POST['PhoneNumber'];
            $deliveryAddress = $_POST['DeliveryAddress'];
            $updateSql = "UPDATE Customer SET CustomerName = '$customerName', PhoneNumber = '$phoneNumber', DeliveryAddress = '$deliveryAddress' WHERE CustomerID = $id";
            break;
        case 'order':
            $customerId = $_POST['CustomerID'];
            $orderDate = $_POST['OrderDate'];
            $updateSql = "UPDATE `Order` SET CustomerID = '$customerId', OrderDate = '$orderDate' WHERE OrderID = $id";
            break;
        case 'product':
            $productName = $_POST['ProductName'];
            $price = $_POST['Price'];
            $orderId = $_POST['OrderID'];
            $updateSql = "UPDATE Product SET ProductName = '$productName', Price = '$price', OrderID = '$orderId' WHERE ProductID = $id";
            break;
        case 'order_detail':
            $productId = $_POST['ProductID'];
            $quantity = $_POST['Quantity'];
            $orderId = $_POST['OrderID'];
            $updateSql = "UPDATE OrderDetail SET ProductID = '$productId', Quantity = '$quantity', OrderID = '$orderId' WHERE OrderDetailID = $id";
            break;
        default:
            echo "Invalid type.";
            exit;
    }

    // Run the update query
    if ($conn->query($updateSql)) {
        // Use JavaScript to redirect after successful update
        echo "<script>
            alert('Record updated successfully!');
            window.location.href='" . $type . "_list.php';
        </script>";
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?php echo ucfirst($type); ?></title>
    <link rel="stylesheet" href="style.css">
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
            padding: 30px;
            width: 400px; /* Width for the form */
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
            color: #555; /* Slightly lighter color for labels */
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s; /* Transition effect for the border color */
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus {
            border-color: #007bff; /* Highlighted border color on focus */
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff; /* Primary button color */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3; /* Darker shade for hover effect */
        }

        a {
            display: inline-block;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline; /* Underline effect on hover */
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit <?php echo ucfirst($type); ?></h2>
    <form method="POST" action="">
        <?php if ($type == 'customer'): ?>
            <label for="CustomerName">Customer Name:</label>
            <input type="text" name="CustomerName" value="<?php echo htmlspecialchars($item['CustomerName']); ?>" required>

            <label for="PhoneNumber">Phone Number:</label>
            <input type="text" name="PhoneNumber" value="<?php echo htmlspecialchars($item['PhoneNumber']); ?>" required>

            <label for="DeliveryAddress">Delivery Address:</label>
            <input type="text" name="DeliveryAddress" value="<?php echo htmlspecialchars($item['DeliveryAddress']); ?>" required>

        <?php elseif ($type == 'order'): ?>
            <label for="CustomerID">Customer ID:</label>
            <input type="text" name="CustomerID" value="<?php echo htmlspecialchars($item['CustomerID']); ?>" required>

            <label for="OrderDate">Order Date:</label>
            <input type="date" name="OrderDate" value="<?php echo htmlspecialchars($item['OrderDate']); ?>" required>

        <?php elseif ($type == 'product'): ?>
            <label for="ProductName">Product Name:</label>
            <input type="text" name="ProductName" value="<?php echo htmlspecialchars($item['ProductName']); ?>" required>

            <label for="Price">Price:</label>
            <input type="number" step="0.01" name="Price" value="<?php echo htmlspecialchars($item['Price']); ?>" required>

            <label for="OrderID">Order ID:</label>
            <input type="text" name="OrderID" value="<?php echo htmlspecialchars($item['OrderID']); ?>" required>

        <?php elseif ($type == 'order_detail'): ?>
            <label for="ProductID">Product ID:</label>
            <input type="text" name="ProductID" value="<?php echo htmlspecialchars($item['ProductID']); ?>" required>

            <label for="Quantity">Quantity:</label>
            <input type="number" name="Quantity" value="<?php echo htmlspecialchars($item['Quantity']); ?>" required>

            <label for="OrderID">Order ID:</label>
            <input type="text" name="OrderID" value="<?php echo htmlspecialchars($item['OrderID']); ?>" required>
        <?php endif; ?>

        <button type="submit">Update</button>
        <a href="<?php echo $type . '_list.php'; ?>">Cancel</a>
    </form>
</div>

</body>
</html>

<?php $conn->close(); ?>
