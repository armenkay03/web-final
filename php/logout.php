<?php
session_start();


require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); 
$dotenv->load();
$_SESSION['message'] = "You are now logged out";
unset($_SESSION['username']);
session_destroy();
$redirectUrl = $_ENV['REDIRECT_URL'] ?? '../php/index.php';
header("Location: $redirectUrl");
exit();
