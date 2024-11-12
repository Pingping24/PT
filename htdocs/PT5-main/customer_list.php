<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table tr,
table td,
table th {
    border: none; /* walang border ang bawat row at cell */
}
    </style>
</head>
<body>

<?php
    include("menu.php");
    include("database.php");
?>

<a href='add.php?type=customer' style="margin-left: 140px;">Add Customer</a>

<table border='1' class='table'>
    <th colspan="5" style="text-align: center; font-size: 35px; background-color: white; color: black;">Customers</tr>
    <tr>
        <th>Customer ID</th>
        <th>Customer Name</th>
        <th>Phone Number</th>
        <th>Delivery Address</th>
        <th width="210px">Actions</th>
    </tr>

    <?php
    $sql = "SELECT CustomerID, CustomerName, PhoneNumber, DeliveryAddress FROM Customer";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['CustomerID']}</td>
                    <td>{$row['CustomerName']}</td>
                    <td>{$row['PhoneNumber']}</td>
                    <td>{$row['DeliveryAddress']}</td>
                    <td>
                        <a href='edit.php?id={$row['CustomerID']}&type=customer'>Edit</a>
                        <a href='delete.php?id=" . $row['CustomerID'] . "&type=customer' onclick='return confirm(\"Are you sure you want to delete this customer?\");'>Delete</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No customers found</td></tr>";
    }
    ?>

</table>



<?php $conn->close(); ?>

</body>
</html>
