<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product List</title>
  <link rel="stylesheet" href="style.css">
  <style>
      .image {
          border-radius: 5px;
          width: 50px;
          height: 50px;
      }
      table {
          width: 100%;
          border-collapse: collapse;
      }
      th, td {
          padding: 15px;
          text-align: left;
          border: 1px solid #ddd;
      }
      th {
          background-color: #f2f2f2;
      }
      a {
          color: #4CAF50;
          text-decoration: none;
      }
      a:hover {
          text-decoration: underline;
      }
  </style>
</head>
<body>

<?php
include("menu.php"); // Menu inclusion
include("database.php"); // Include the database connection
echo "<br>";
echo "<a href='add_product.php' style='margin-left: 140px;'>Add Product</a>";

echo "<table class='table'>
        <thead>
            <tr>
                <th colspan='5' style='text-align: center; font-size: 35px; background-color: white; color: black;'>Product List</th>
            </tr>
            <tr>
                <th>Product Image</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th width='210px'>Actions</th>
            </tr>
        </thead>
        <tbody>";

$sql = "SELECT ProductID, ProductName, Price, productImage FROM Product";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>";
        if (!empty($row['productImage'])) {
            echo "<img src='" . htmlspecialchars($row['productImage']) . "' alt='Product Image' class='image'>";
        } else {
            echo "No Image";
        }
        echo "</td>
                <td>{$row['ProductID']}</td>
                <td>{$row['ProductName']}</td>
                <td>{$row['Price']}</td>
                <td>
                    <a class='nav-button' href='edit_product.php?id=" . $row['ProductID'] . "'>Edit</a> | 
                    <a class='nav-button' href='delete.php?id=" . $row['ProductID'] . "&type=product' onclick='return confirm(\'Are you sure you want to delete this product?\');'>Delete</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No products found</td></tr>";
}

echo "</tbody></table>";

$conn->close();
?>

</body>
</html>
