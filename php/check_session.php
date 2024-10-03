<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    echo json_encode(['logged_in' => true]);
} else {
    echo json_encode(['logged_in' => false]);
}

