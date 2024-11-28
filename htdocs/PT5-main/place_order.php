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

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerName = $_POST['customerName'];
    $phoneNumber = $_POST['phoneNumber'];
    $deliveryAddress = $_POST['deliveryAddress'];

    // Insert the new customer into the database
    $sql = "INSERT INTO Customer (CustomerName, PhoneNumber, DeliveryAddress) VALUES ('$customerName', '$phoneNumber', '$deliveryAddress')";

    if ($conn->query($sql) === TRUE) {
        echo "New customer added successfully!";
        // Redirect back to the customer list page after successful addition
        header("Location: customer_list.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <style>
        body {
            background-color: #ffc0cbdc;
            font-family: Arial, sans-serif;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], input[type="date"] {
            width: 98%;
            padding: 7px 2px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"], .cancel-link {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
        }
        input[type="submit"]:hover, .cancel-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php
include("database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input and sanitize it
    $customerName = $_POST['customerName'];
    $phoneNumber = $_POST['phoneNumber'];
    $deliveryAddress = $_POST['deliveryAddress'];

    // Check if inputs are not empty
    if (!empty($customerName) && !empty($phoneNumber) && !empty($deliveryAddress)) {
        // Prepare an SQL statement to insert the new customer
        $stmt = $conn->prepare("INSERT INTO Customer (CustomerName, PhoneNumber, DeliveryAddress) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $customerName, $phoneNumber, $deliveryAddress);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect back to the customer list page after successful addition
            header("Location: customer_list.php");
            exit();
        } else {
            echo "Error: Could not add customer. " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Please fill out all fields.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
</head>
<body>
    <h2>Add New Customer</h2>
    <form action="add.php" method="POST">
        <label for="customerName">Customer Name:</label>
        <input type="text" id="customerName" name="customerName" required><br>

        <label for="phoneNumber">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" required><br>

        <label for="deliveryAddress">Delivery Address:</label>
        <input type="text" id="deliveryAddress" name="deliveryAddress" required><br>

        <input type="submit" value="Add Customer">
    </form>
    <a href="customer_list.php">Back to Customer List</a>
</body>
</html>

</body>
</html>

</html>
