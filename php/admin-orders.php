<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->load();
$servername = $_ENV['DB_SERVER'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = 'crud';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch pending orders
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM orders WHERE status='Pending'";
    $result = $conn->query($sql);

    $orders = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orderId = $row['id'];

            // Fetch order items for each order along with product names
            $itemsSql = "SELECT oi.quantity, p.name AS product_name 
                         FROM order_items oi 
                         LEFT JOIN products p ON oi.product_id = p.id 
                         WHERE oi.order_id = $orderId";
            $itemsResult = $conn->query($itemsSql);

            $items = [];
            while ($itemRow = $itemsResult->fetch_assoc()) {
                $items[] = [
                    'product' => $itemRow['product_name'], // Get the product name
                    'quantity' => $itemRow['quantity']
                ];
            }

            $orders[] = [
                'id' => $row['id'],
                'customer_name' => $row['customer_name'],
                'customer_email' => $row['customer_email'],
                'status' => $row['status'],
                'order_date' => $row['order_date'],
                'items' => $items
            ];
        }
    }

    // If no orders were found, display the appropriate message
    if (empty($orders)) {
        $orders = ["message" => "No orders to be displayed."];
    }

    header('Content-Type: application/json');
    echo json_encode($orders);
}

// Handle order actions (Accept or Reject)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = (int)$_POST['order_id'];
    $action = $conn->real_escape_string($_POST['action']); 

    $status = $action === 'accept' ? 'Accepted' : 'Rejected';
    $updateSql = "UPDATE orders SET status='$status' WHERE id=$orderId";

    if ($conn->query($updateSql) === TRUE) {
        
        if ($action === 'accept') {
            // Fetch the items in the order
            $itemsSql = "SELECT oi.product_id, oi.quantity, p.quantity AS product_stock 
                         FROM order_items oi 
                         LEFT JOIN products p ON oi.product_id = p.id 
                         WHERE oi.order_id = $orderId";
            $itemsResult = $conn->query($itemsSql);

            while ($itemRow = $itemsResult->fetch_assoc()) {
                $productId = $itemRow['product_id'];
                $orderedQuantity = $itemRow['quantity'];
                $currentStock = $itemRow['product_stock'];


                $newStock = $currentStock - $orderedQuantity;

               
                $updateProductSql = "UPDATE products SET quantity=$newStock WHERE id=$productId";
                $conn->query($updateProductSql);
            }
        }
        echo "Order $status successfully.";
    } else {
        echo "Error: " . $updateSql . "<br>" . $conn->error;
    }
}

$conn->close();
