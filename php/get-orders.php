<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "34.173.30.56";
$username = "root";
$password = "nemra26";
$dbname = "crud";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders and their associated items with product names and descriptions
$sql = "SELECT o.id AS order_id, o.customer_name, o.customer_email, o.status, o.order_date, 
               oi.product_id, p.name AS product_name, p.description AS product_description, oi.quantity 
        FROM orders o 
        LEFT JOIN order_items oi ON o.id = oi.order_id 
        LEFT JOIN products p ON oi.product_id = p.id 
        WHERE o.status IN ('Accepted', 'Rejected')";

$result = $conn->query($sql);

$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orderId = $row['order_id'];

        // Add the items to the order
        $items[] = [
            'product_id' => $row['product_id'],
            'product_name' => $row['product_name'], // Retrieve the product name
            'product_description' => $row['product_description'], // Retrieve the product description
            'quantity' => $row['quantity']
        ];

        // Check if this order already exists in the orders array
        if (!isset($orders[$orderId])) {
            $orders[$orderId] = [
                'id' => $orderId,
                'customer_name' => $row['customer_name'],
                'customer_email' => $row['customer_email'],
                'status' => $row['status'],
                'order_date' => $row['order_date'],
                'items' => [] // Initialize items array
            ];
        }

        // Append the item to the order
        $orders[$orderId]['items'][] = $items[count($items) - 1];
    }
}

// Re-index the orders array to make it a numerically indexed array
$orders = array_values($orders);

header('Content-Type: application/json');
echo json_encode($orders);

$conn->close();
