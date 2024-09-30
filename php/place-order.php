<?php
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and validate it
    if (isset($_POST['customerName'], $_POST['customerEmail'], $_POST['product'], $_POST['quantity'])) {
        $customerName = $_POST['customerName'];
        $customerEmail = $_POST['customerEmail'];
        $product = $_POST['product'];
        $quantity = (int)$_POST['quantity']; // Ensure quantity is an integer

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
            $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product, quantity) VALUES (?, ?, ?)");
            if ($itemStmt === false) {
                die("Error preparing item statement: " . $conn->error);
            }

            // Bind the parameters (iii -> integer, string, integer)
            $itemStmt->bind_param("isi", $orderId, $product, $quantity);

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
        echo "Error: Missing required form data.";
    }
}

// Close the database connection
$conn->close();
