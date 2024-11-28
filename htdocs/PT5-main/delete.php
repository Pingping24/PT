<?php
include("database.php"); // Include your database connection

// Debugging: Check if the 'id' and 'type' parameters are set
if (!isset($_GET['id']) || !isset($_GET['type'])) {
    echo "Error: Missing 'id' or 'type' in the URL parameters.<br>";
    echo "id: " . (isset($_GET['id']) ? $_GET['id'] : "not set") . "<br>";
    echo "type: " . (isset($_GET['type']) ? $_GET['type'] : "not set") . "<br>";
    exit();
}


// Check if the id and type parameters are set in the URL
if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Define SQL query based on the type
        switch ($type) {
            case 'customer':
                $sql = "DELETE FROM Customer WHERE CustomerID = ?";
                break;
            case 'order':
                $sql = "DELETE FROM `Order` WHERE OrderID = ?";
                break;
            case 'product':
                // First, delete from OrderDetail to avoid foreign key constraint error
                $deleteOrderDetail = "DELETE FROM OrderDetail WHERE ProductID = ?";
                $stmtOrderDetail = $conn->prepare($deleteOrderDetail);
                $stmtOrderDetail->bind_param("i", $id);
                $stmtOrderDetail->execute();

                // Now delete the product
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
            // Commit the transaction if successful
            $conn->commit();
            // Successfully deleted, use JavaScript to redirect
            echo "<script>
                alert('Record deleted successfully!');
                window.location.href = document.referrer;
            </script>";
            exit();
        } else {
            // Deletion failed, roll back the transaction
            $conn->rollback();
            echo "Error deleting record: " . $conn->error;
        }

        $stmt->close();
    } catch (Exception $e) {
        // Roll back the transaction if something goes wrong
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request. Check the URL parameters.";
}

// Close the connection
$conn->close();
?>
