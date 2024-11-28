<?php
    include("menu.php");
    include("database.php");

    // Enable error reporting to see PHP errors directly
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Debugging: Check if the form data is being received
        echo "Product Name: " . $_POST['productName'] . "<br>";  // Debugging line
        echo "Price: " . $_POST['price'] . "<br>";  // Debugging line

        $productName = $_POST['productName'];
        $price = $_POST['price'];

        // Handle image upload
        $imagePath = "";
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            echo "Image uploaded: " . $_FILES['image']['name'] . "<br>";  // Debugging line

            // Define the upload directory
            $targetDir = "uploads/";
            $fileName = basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . $fileName;

            // Check if the uploads directory exists, if not create it
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Validate image file type
            $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (in_array($fileExtension, $allowedFileTypes)) {
                // Move the uploaded file to the uploads directory
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $imagePath = $targetFilePath; // Store the image path
                } else {
                    echo "Error uploading image.";
                }
            } else {
                echo "Invalid image type. Only JPG, JPEG, PNG, and GIF are allowed.";
            }
        } else {
            echo "No image uploaded.<br>";
        }

        // Insert product into database
        if (!empty($productName) && !empty($price)) {
            $sql = "INSERT INTO Product (ProductName, Price, productImage) VALUES (?, ?, ?)";
            
            if ($stmt = $conn->prepare($sql)) {
                // Bind parameters and execute the SQL query
                $stmt->bind_param("sss", $productName, $price, $imagePath);
                if ($stmt->execute()) {
                    echo "Product added successfully!";
                    // Redirect to the product list page after successful insertion
                    header("Location: product_list.php"); // Change 'product_list.php' to your actual product list page
                    exit(); // Ensure no further code is executed after redirect
                } else {
                    echo "Error: " . $stmt->error; // Debugging: Show SQL error
                }
                $stmt->close();
            } else {
                echo "Error preparing SQL: " . $conn->error; // Debugging: Show error if SQL preparation fails
            }
        } else {
            echo "Please fill out all fields.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
</style>
</head>
<body>
<h2>Add New Product</h2>
<form action="add_product.php" method="POST" enctype="multipart/form-data" class="container">
    <label for="productName">Product Name:</label><br>
    <input type="text" id="productName" name="productName" required><br><br>

    <label for="price">Price:</label><br>
    <input type="text" id="price" name="price" required><br><br>

    <label for="image">Product Image:</label><br>
    <input type="file" id="image" name="image"><br><br>

    <button type="submit" value="Add Product">Add Product</button>
</form>

<?php
$conn->close();
?>

</body>
</html>
