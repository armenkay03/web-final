<?php
header('Content-Type: application/json');

// Database connection parameters
$servername = "34.173.30.56"; // Database server
$username = "root"; // Database username
$password = "nemra26"; // Database password
$dbname = "contact"; // Database name

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

// Return the submissions as JSON without unnecessary escaping
echo json_encode($submissions, JSON_UNESCAPED_SLASHES);
