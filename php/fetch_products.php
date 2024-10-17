<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->load();
$servername = $_ENV['DB_SERVER'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD']; 
$dbname = 'crud';         


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

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
