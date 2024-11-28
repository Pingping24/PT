<?php

// Define the directory for uploads
$uploadDir = 'uploads/';

// Check if the form was submitted and a file was uploaded
// Handle form submission
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data for customer info
    $customerName = $_POST['CustomerName'];
    $phoneNumber = $_POST['PhoneNumber'];
    $deliveryAddress = $_POST['DeliveryAddress'];

    // Initialize the variable for the profile image (default is NULL if no file is uploaded)
    $profileImage = null;

    // Check if a file is uploaded and if there are no errors
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
        // File information
        $targetDir = "uploads/"; // Directory to store the uploaded images
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]); // Target file path
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION)); // File extension

        // Check if the uploaded file is a valid image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            // File is an image, proceed with upload

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                // Successfully uploaded, get the file name to store in the database
                $profileImage = basename($_FILES["fileToUpload"]["name"]);
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        } else {
            echo "File is not an image.";
            exit;
        }
    }

    // Update SQL query (including profile image if uploaded)
    $updateSql = "UPDATE Customer SET CustomerName = '$customerName', PhoneNumber = '$phoneNumber', DeliveryAddress = '$deliveryAddress'";
    if ($profileImage) {
        $updateSql .= ", ProfileImage = '$profileImage'"; // Update profile image if uploaded
    }
    $updateSql .= " WHERE CustomerID = $id";

    // Execute the update query
    if ($conn->query($updateSql)) {
        // Redirect to the customer list page after successful update
        echo "<script>
            alert('Record updated successfully!');
            window.location.href='customer_list.php';
        </script>";
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


?>
