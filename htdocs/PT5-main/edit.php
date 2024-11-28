<?php
include("database.php"); // Include the database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the ID and type are provided
if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    // Define SQL queries based on the type
    if ($type === 'customer') {
        $sql = "SELECT CustomerID, CustomerName, PhoneNumber, DeliveryAddress, profileimage FROM Customer WHERE CustomerID = $id";
        $result = $conn->query($sql);
        $item = $result->fetch_assoc();
    } else {
        echo "Invalid request.";
        exit;
    }
}

// Handle form submission for editing customer
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerName = $_POST['CustomerName'];
    $phoneNumber = $_POST['PhoneNumber'];
    $deliveryAddress = $_POST['DeliveryAddress'];

    // Initialize the upload path
    $uploadedFile = null;
    $uploadSuccess = true;

    // Check if a new image is uploaded
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
        // Define the upload directory
        $uploadDir = 'uploads/';

        // Get the file details
        $fileName = basename($_FILES['fileToUpload']['name']);
        $fileTmpName = $_FILES['fileToUpload']['tmp_name'];
        $fileSize = $_FILES['fileToUpload']['size'];
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Validate the file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($fileType), $allowedTypes)) {
            echo "Only image files are allowed (JPG, JPEG, PNG, GIF).";
            $uploadSuccess = false;
        }

        // Validate file size (max 5MB)
        if ($fileSize > 5000000) {
            echo "File size is too large. Maximum allowed size is 5MB.";
            $uploadSuccess = false;
        }

        // Move the uploaded file to the uploads folder
        if ($uploadSuccess) {
            $newFileName = uniqid('', true) . '.' . $fileType; // Generate a unique file name
            $targetFilePath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpName, $targetFilePath)) {
                $uploadedFile = $newFileName;
            } else {
                echo "Error uploading the file.";
                $uploadSuccess = false;
            }
        }
    }

    // Update the customer details in the database
    if ($uploadSuccess) {
        if ($uploadedFile) {
            // If a new image was uploaded, update the image path
            $sql = "UPDATE Customer SET CustomerName = '$customerName', PhoneNumber = '$phoneNumber', DeliveryAddress = '$deliveryAddress', profileimage = '$uploadedFile' WHERE CustomerID = $id";
        } else {
            // No new image, just update the other fields
            $sql = "UPDATE Customer SET CustomerName = '$customerName', PhoneNumber = '$phoneNumber', DeliveryAddress = '$deliveryAddress' WHERE CustomerID = $id";
        }

        if ($conn->query($sql)) {
            echo "<script>alert('Customer updated successfully!'); window.location.href='customer_list.php';</script>";
        } else {
            echo "Error updating customer: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
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

<h2>Edit Customer</h2>

<form action="edit.php?id=<?php echo $id; ?>&type=<?php echo $type; ?>" method="POST" enctype="multipart/form-data" class="container">
    <label for="CustomerName">Customer Name:</label>
    <input type="text" name="CustomerName" value="<?php echo htmlspecialchars($item['CustomerName']); ?>" required><br><br>
    
    <label for="PhoneNumber">Phone Number:</label>
    <input type="text" name="PhoneNumber" value="<?php echo htmlspecialchars($item['PhoneNumber']); ?>" required><br><br>
    
    <label for="DeliveryAddress">Delivery Address:</label>
    <input type="text" name="DeliveryAddress" value="<?php echo htmlspecialchars($item['DeliveryAddress']); ?>" required><br><br>

    <label for="fileToUpload">Profile Image:</label>
    <input type="file" name="fileToUpload" accept="image/*"><br><br>

    <button type="submit">Update</button>
</form>

</body>
</html>
