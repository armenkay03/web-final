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

// Fetch products from the database
$query = "SELECT id, name, description, price, quantity, date FROM products"; // Ensure quantity is included
$result = $conn->query($query);

$products = [];

if ($result->num_rows > 0) {
    // Store data in an array
    while ($row = $result->fetch_assoc()) {
        // Format the date
        $date = new DateTime($row['date']);
        $row['date'] = $date->format('m-d-Y'); // Change the format to month-day-year
        $products[] = $row; // Store the entire product row including quantity
    }
} 

// Close the connection
$conn->close();

// Return products as a JSON response
header('Content-Type: application/json');
echo json_encode($products);
