<?php
include("database.php"); // Include the database connection

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Handle image upload
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
        // Define upload directory and allowed file types
        $uploadDir = 'uploads/';
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        
        // Get the file details
        $fileName = basename($_FILES['productImage']['name']);
        $fileTmpName = $_FILES['productImage']['tmp_name'];
        $fileSize = $_FILES['productImage']['size'];
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Validate file type
        if (!in_array(strtolower($fileType), $allowedTypes)) {
            echo "Only image files are allowed (JPG, JPEG, PNG, GIF).";
            exit;
        }

        // Validate file size (max 5MB)
        if ($fileSize > 5000000) {
            echo "File size is too large. Maximum allowed size is 5MB.";
            exit;
        }

        // Generate a unique file name and move the uploaded file
        $newFileName = uniqid('', true) . '.' . $fileType;
        $targetFilePath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpName, $targetFilePath)) {
            // Update the database with the new image path
            $sql = "UPDATE Product SET productImage = ? WHERE ProductID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $targetFilePath, $productId);
            if ($stmt->execute()) {
                echo "Image uploaded successfully.";
                header("Location: product_list.php"); // Redirect to the product list page
                exit;
            } else {
                echo "Error updating product image.";
            }
        } else {
            echo "Error uploading the file.";
        }
    }
} else {
    echo "Product ID is missing.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product Image</title>
</head>
<body>

<h2>Upload Image for Product</h2>

<form action="productUploadEdit_image.php?id=<?php echo $productId; ?>" method="POST" enctype="multipart/form-data">
    <label for="productImage">Choose an Image:</label>
    <input type="file" name="productImage" accept="image/*" required><br><br>
    <button type="submit">Upload Image</button>
</form>

</body>
</html>
