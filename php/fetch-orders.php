<?php

require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->load();
$servername = $_ENV['DB_SERVER'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD']; 
$dbname = "crud";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all orders
$sql = "SELECT * FROM orders"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<li>";
        echo "<h3>Order ID: " . $row["id"] . "</h3>";
        echo "<p>Customer: " . $row["customer_name"] . " (" . $row["customer_email"] . ")</p>";
        echo "<p>Status: " . $row["status"] . "</p>";
        echo "<p>Order Date: " . $row["order_date"] . "</p>";
        echo "<h4>Items:</h4>";

        $orderId = $row["id"];
        $itemSql = "SELECT * FROM order_items WHERE order_id = $orderId"; 
        $itemResult = $conn->query($itemSql);

        echo "<ul>";
        if ($itemResult->num_rows > 0) {
            while ($item = $itemResult->fetch_assoc()) {
                echo "<li>" . $item["product_name"] . " (Quantity: " . $item["quantity"] . ")</li>";
            }
        } else {
            echo "<li>No items found for this order.</li>";
        }
        echo "</ul>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "No orders found.";
}


$conn->close();

