<?php
// fetch_products.php

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

// Fetch products from the database where quantity is greater than zero
$query = "SELECT id, name, description, price, quantity, date FROM products WHERE quantity > 0"; // Exclude products with zero quantity
$result = $conn->query($query);

$products = [];

if ($result->num_rows > 0) {
    // Store data in an array
    while ($row = $result->fetch_assoc()) {
        // Format the date as mm/dd/yyyy using PHP's date function
        $formattedDate = date("m/d/Y", strtotime($row['date']));
        
        // Add the formatted date to the product array
        $row['date'] = $formattedDate; // Replace the original date with the formatted one

        $products[] = $row; // Store the product row with the formatted date
    }
}

// Return products as a JSON response
header('Content-Type: application/json');
echo json_encode($products);

// Close the connection
$conn->close();
