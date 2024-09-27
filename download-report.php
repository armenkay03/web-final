<?php
// download_report.php

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

// Get start and end dates from the query parameters
$startDate = $_GET['start'];
$endDate = $_GET['end'];

// Fetch products between the specified dates
$query = "SELECT * FROM products WHERE date BETWEEN ? AND ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();

// Load the PHPExcel library
require 'vendor/autoload.php'; // Make sure you have PHPExcel or PhpSpreadsheet installed

// Create new PHPExcel object
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set column headers
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Product Name');
$sheet->setCellValue('C1', 'Description');
$sheet->setCellValue('D1', 'Price');
$sheet->setCellValue('E1', 'Quantity');
$sheet->setCellValue('F1', 'Date Added');

// Populate data
$row = 2;
while ($product = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $product['id']);
    $sheet->setCellValue('B' . $row, $product['name']);
    $sheet->setCellValue('C' . $row, $product['description']);
    $sheet->setCellValue('D' . $row, $product['price']);
    $sheet->setCellValue('E' . $row, $product['quantity']);
    $sheet->setCellValue('F' . $row, $product['date']);
    $row++;
}

// Set the filename and download
$filename = "inventory_report_" . date('Ymd') . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Write file to output
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save('php://output');

// Close the connection
$conn->close();
exit();
?>
