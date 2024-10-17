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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and validate it
    if (isset($_POST['customerName'], $_POST['customerEmail'], $_POST['product'], $_POST['quantity'])) {
        $customerName = $_POST['customerName'];
        $customerEmail = $_POST['customerEmail'];
        $productId = $_POST['product']; // Use product ID
        $quantity = (int)$_POST['quantity']; // Ensure quantity is an integer

        // Debugging: Log the values being submitted
        error_log("Product ID: " . $productId);
        error_log("Quantity: " . $quantity);

        // Insert into the 'orders' table first
        $orderStmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email) VALUES (?, ?)");
        if ($orderStmt === false) {
            die("Error preparing order statement: " . $conn->error);
        }

        // Bind the parameters
        $orderStmt->bind_param("ss", $customerName, $customerEmail);

        // Execute the statement to create a new order
        if ($orderStmt->execute()) {
            $orderId = $orderStmt->insert_id; // Get the last inserted order ID

            // Now insert into the 'order_items' table
            $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
            if ($itemStmt === false) {
                die("Error preparing item statement: " . $conn->error);
            }

            // Bind the parameters (iii -> integer, integer, integer)
            $itemStmt->bind_param("iii", $orderId, $productId, $quantity);

            // Execute the statement to add order item
            if ($itemStmt->execute()) {
                echo "Order placed successfully!";
            } else {
                echo "Error placing order item: " . $itemStmt->error;
            }

            // Close the item statement
            $itemStmt->close();
        } else {
            echo "Error placing order: " . $orderStmt->error;
        }

        // Close the order statement
        $orderStmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error: Missing required form data."]);
    }
}

// Close the database connection
$conn->close();
