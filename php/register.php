<?php
session_start();

// Connect to database
$db = new mysqli("34.173.30.56", "root", "nemra26", "mysite");

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (isset($_POST['register_btn'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    // Check if username exists
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<script>alert("Username already exists")</script>';
    } else {
        if ($password == $password2) {
            // Hash the password securely
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into the database
            $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['message'] = "You are now registered and logged in";
                $_SESSION['username'] = $username;
                header("location:../user/index.html");
                exit();
            } else {
                $_SESSION['message'] = "Registration failed. Please try again.";
            }
        } else {
            $_SESSION['message'] = "Passwords do not match.";
        }
    }
}
