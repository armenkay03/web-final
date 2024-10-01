<?php
$servername = "34.173.30.56";
$username = "root";
$password = "nemra26";
$dbname = "crud";

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
    header('Content-Type: application/json');
    echo json_encode($orders);
}

// Handle order actions (Accept or Reject)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = (int)$_POST['order_id'];
    $action = $conn->real_escape_string($_POST['action']); // 'accept' or 'reject'

    $status = $action === 'accept' ? 'Accepted' : 'Rejected';
    $updateSql = "UPDATE orders SET status='$status' WHERE id=$orderId";

    if ($conn->query($updateSql) === TRUE) {
        echo "Order $status successfully.";
    } else {
        echo "Error: " . $updateSql . "<br>" . $conn->error;
    }
}

$conn->close();
