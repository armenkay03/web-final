<?php
header('Content-Type: application/json');
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->load();
$servername = $_ENV['DB_SERVER'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = "contact";

// Create connection to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Fetch all contact submissions
$sql = "SELECT id, name, email, message, created_at FROM contact";
$result = $conn->query($sql);

// Store results in an array
$submissions = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Remove "\r\n" and other special characters before encoding
        $row['message'] = preg_replace("/\r\n|\r|\n/", ' ', $row['message']);
        $submissions[] = $row;
    }
}

// Close the database connection
$conn->close();

echo json_encode($submissions, JSON_UNESCAPED_SLASHES);
