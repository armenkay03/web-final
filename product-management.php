<?php
// Database connection parameters
$host = '34.173.30.56';  // Replace with your database host
$dbname = 'crud';         // Database name
$user = 'root';           // Database user
$password = 'nemra26';    // Database password

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        // Get data from form
        $productId = $_POST['product_id'];
        $productName = $_POST['product_name'];
        $productDescription = $_POST['product_description'];
        $productPrice = $_POST['product_price'];
        $productQuantity = $_POST['product_quantity'];
        $productDate = $_POST['product_date'];

        // Check if the product ID already exists
        $checkQuery = "SELECT * FROM products WHERE id = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Product exists, update the quantity and date
            $updateQuery = "UPDATE products SET quantity = quantity + ?, date = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("isi", $productQuantity, $productDate, $productId);
            $updateStmt->execute();
            echo "Product quantity updated successfully.";
        } else {
            // Insert new product
            $insertQuery = "INSERT INTO products (id, name, description, price, quantity, date) VALUES (?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("isssis", $productId, $productName, $productDescription, $productPrice, $productQuantity, $productDate);
            $insertStmt->execute();
            echo "New product added successfully.";
        }

        $stmt->close();
    } elseif ($action === 'delete') {
        // Delete a product by ID
        $deleteProductId = $_POST['delete_product_id'];
        $deleteQuery = "DELETE FROM products WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $deleteProductId);
        $deleteStmt->execute();
        echo "Product deleted successfully.";
        $deleteStmt->close();
    }
}

// Close the connection
$conn->close();

