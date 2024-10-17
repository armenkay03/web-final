<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->load();
$servername = $_ENV['DB_SERVER'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];    
$dbname = "contact";


$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get the input data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);


    $stmt = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        echo "success";  
    } else {
        echo "Error: " . $stmt->error;  
    }

    $stmt->close();
} else {
    echo "Invalid request method. Please submit the form using POST.";
}

// Close the database connection
$conn->close();
