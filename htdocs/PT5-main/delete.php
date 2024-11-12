<?php
include("database.php"); // Include your database connection

// Check if the id and type parameters are set in the URL
if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    // Debugging output
    // echo "<script>console.log('ID: $id, Type: $type');</script>";

    // Define SQL query based on the type
    switch ($type) {
        case 'customer':
            $sql = "DELETE FROM Customer WHERE CustomerID = ?";
            break;
        case 'order':
            $sql = "DELETE FROM `Order` WHERE OrderID = ?";
            break;
        case 'product':
            $sql = "DELETE FROM Product WHERE ProductID = ?";
            break;
        case 'order_detail':
            $sql = "DELETE FROM OrderDetail WHERE OrderDetailID = ?";
            break;
        default:
            die("Invalid type specified.");
    }

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Bind the ID parameter
    if ($stmt->execute()) {
        // Successfully deleted, use JavaScript to redirect
        echo "<script>
            alert('Record deleted successfully!');
            window.location.href = document.referrer;
        </script>";
        exit();
    } else {
        // Deletion failed
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request. Check the URL parameters.";
}

// Close the connection
$conn->close();
?>
