<?php
// Database connection parameters
$servername = "34.173.30.56"; // Replace with your database server
$username = "root";        // Replace with your database username
$password = "nemra26";     // Replace with your database password
$dbname = "contact";       // Replace with your database name

// Create connection to MySQL database
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

    // Prepare SQL insert statement using prepared statements
    $stmt = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        echo "success";  // Respond with 'success' for AJAX
    } else {
        echo "Error: " . $stmt->error;  // Respond with error message
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid request method. Please submit the form using POST.";
}

// Close the database connection
$conn->close();

