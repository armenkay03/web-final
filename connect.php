<?php
// Database connection parameters
$servername = "34.173.30.56"; // Replace with your database server
$username = "root";        // Replace with your database username
$password = "nemra26";     // Replace with your database password
$dbname = "contact";       // Replace with your database name
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add Product
    if ($_POST['action'] === 'add') {
        $product_id = $conn->real_escape_string($_POST['product_id']);
        $product_name = $conn->real_escape_string($_POST['product_name']);
        $product_description = $conn->real_escape_string($_POST['product_description']);
        $product_price = $conn->real_escape_string($_POST['product_price']);
        $product_quantity = (int) $_POST['product_quantity']; // Cast to int
        $product_date = $conn->real_escape_string($_POST['product_date']);

        $sql = "INSERT INTO products (id, name, description, price, quantity, date_added) VALUES ('$product_id', '$product_name', '$product_description', '$product_price', '$product_quantity', '$product_date')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New product added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    // Update Product
    elseif ($_POST['action'] === 'update') {
        $id = $conn->real_escape_string($_POST['update_product_id']);
        $description = isset($_POST['update_description']) ? $conn->real_escape_string($_POST['update_description']) : null;
        $price = isset($_POST['update_price']) ? $conn->real_escape_string($_POST['update_price']) : null;

        // Check quantity field
        $quantity = isset($_POST['update_quantity']) && $_POST['update_quantity'] !== '' ? (int) $_POST['update_quantity'] : null; // Cast to int or null
        $date = isset($_POST['update_date']) ? $conn->real_escape_string($_POST['update_date']) : null;

        $fields = [];
        if ($description !== null) $fields[] = "description='$description'";
        if ($price !== null && $price !== '') $fields[] = "price='$price'";
        if ($quantity !== null) $fields[] = "quantity=$quantity"; // Do not include if null
        if ($date !== null && $date !== '') $fields[] = "date_added='$date'";

        if ($fields) {
            $sql = "UPDATE products SET " . implode(", ", $fields) . " WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                echo "Product updated successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "No fields to update.";
        }
    }
    
    // Delete Product
    elseif ($_POST['action'] === 'delete') {
        $id = $conn->real_escape_string($_POST['remove_product_id']);

        $sql = "DELETE FROM products WHERE id='$id'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Product deleted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();