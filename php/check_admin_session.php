<?php
session_start();

// Check if the user is logged in and is "admin"
if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {
    echo json_encode(['admin_logged_in' => true]);
} else {
    echo json_encode(['admin_logged_in' => false]);
}