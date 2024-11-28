<?php
include("database.php");

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $sql = "SELECT * FROM Product WHERE ProductID = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $productName = $row['ProductName'];
            $price = $row['Price'];
            $imagePath = $row['productImage'];
        } else {
            echo "Product not found.";
            exit;
        }
        $stmt->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated product data from the form
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $imagePath = $imagePath;  // Keep the current image if not updated

    // Handle new image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $fileName;
        
        // Validate image file type
        $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedFileTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $imagePath = $targetFilePath; // Update the image path
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Invalid image type.";
        }
    }

    // Update product in the database
    $sql = "UPDATE Product SET ProductName = ?, Price = ?, productImage = ? WHERE ProductID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssi", $productName, $price, $imagePath, $productId);
        if ($stmt->execute()) {
            echo "Product updated successfully!";
            header("Location: product_list.php"); // Redirect to product list after update
            exit();
        } else {
            echo "Error updating product: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-weight: bold;
        }
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

input {
    width: 93%;
    flex: 1; /* Make input field take remaining space */
    padding: 10px 10px;
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

.cancel-btn {
    background-color: white;
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    margin-top: 10px;
}

</style>
</head>
<body>
    <h2>Edit Product</h2>
    <form action="edit_product.php?id=<?php echo $productId; ?>" method="POST" enctype="multipart/form-data" class="container">
        <label for="productName">Product Name:</label><br>
        <input type="text" id="productName" name="productName" value="<?php echo $productName; ?>" required><br><br>

        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price" value="<?php echo $price; ?>" required><br><br>

        <label for="image">Product Image:</label><br>
        <input type="file" id="image" name="image"><br><br>

        <button type="submit">Update Product</button>


    <!-- Cancel button redirecting to product list -->
        <button type="submit" class="cancel-btn">Cancel</button>
    </form>
</body>
</html>
