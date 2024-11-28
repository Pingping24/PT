<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table tr, table td, table th {
            border: none; /* No borders on rows and cells */
        }
        .img {
            border-radius: 50%; /* Make profile image circular */
            width: 50px; /* Adjust width */
            height: 50px; /* Adjust height */
        }
    </style>
</head>
<body>

<?php
include("menu.php");
include("database.php");

// Fetch customer data including the profile image
$sql = "SELECT c.CustomerID, c.CustomerName, c.PhoneNumber, c.DeliveryAddress, c.profileimage
        FROM Customer c";
$result = $conn->query($sql);
?>

<table border="1" class="table">
    <th colspan="6" style="text-align: center; font-size: 35px; background-color: white; color: black;">Customers</th>
    <tr>
        <th>Profile Image</th>
        <th>Customer ID</th>
        <th>Customer Name</th>
        <th>Phone Number</th>
        <th>Delivery Address</th>
        <th width="210px">Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>";
            // Check if there's a profile image and display it
            if (!empty($row['profileimage'])) {
                echo "<img src='uploads/" . htmlspecialchars($row['profileimage']) . "' alt='Profile Image' class='img'>";
            } else {
                echo "No Image";
            }
            echo "</td>";
            echo "<td>{$row['CustomerID']}</td>";
            echo "<td>{$row['CustomerName']}</td>";
            echo "<td>{$row['PhoneNumber']}</td>";
            echo "<td>{$row['DeliveryAddress']}</td>";
            echo "<td>";
            echo "<a <a class='nav-button' href='edit.php?id={$row['CustomerID']}&type=customer'>Edit</a> | ";
            echo "<a class='nav-button' href='delete.php?id={$row['CustomerID']}&type=customer' onclick='return confirm(\"Are you sure you want to delete this customer?\");'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No customers found</td></tr>";
    }
    ?>

</table>

</body>
</html>
