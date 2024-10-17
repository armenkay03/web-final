<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$servername = $_ENV['DB_SERVER'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = "crud"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add Product
if ($_POST['action'] === 'add') {
    $productId = $conn->real_escape_string($_POST['product_id']);
    $productName = $conn->real_escape_string($_POST['product_name']);
    $description = $conn->real_escape_string($_POST['product_description']);
    $price = $conn->real_escape_string($_POST['product_price']);
    $quantity = (int)$_POST['product_quantity']; // Cast to integer
    $date = $conn->real_escape_string($_POST['product_date']); // Assuming this is the date field you want

    $sql = "INSERT INTO products (id, name, description, price, quantity, date) 
            VALUES ('$productId', '$productName', '$description', '$price', $quantity, '$date')"; // Use the appropriate column name for the date
    
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
    $quantity = isset($_POST['update_quantity']) && $_POST['update_quantity'] !== '' ? (int)$_POST['update_quantity'] : null; // Cast to int or null
    $date = isset($_POST['update_date']) && $_POST['update_date'] !== '' ? $conn->real_escape_string($_POST['update_date']) : null; // Capture date

    $fields = [];
    if ($description !== null) $fields[] = "description='$description'";
    if ($price !== null && $price !== '') $fields[] = "price='$price'";
    if ($quantity !== null) $fields[] = "quantity=$quantity"; // Only include if not null
    if ($date !== null) $fields[] = "date='$date'"; // Update the date field

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
    $id = $conn->real_escape_string($_POST['delete_product_id']);

    $sql = "DELETE FROM products WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
