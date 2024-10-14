<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "localhost"; // Database server
$username = "u604612450_josh";        // Database username
$password = "u604612450_josh";            // Database password
$dbname = "Joshuaweb123."; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$date = $_POST['date'];
$time = $_POST['time'];
$notes = $_POST['notes'];

// Fetch customer by email (assume customer already exists in customers table)
$customer_query = "SELECT id FROM customers WHERE email = '$email'";
$customer_result = $conn->query($customer_query);

if ($customer_result->num_rows > 0) {
    $customer = $customer_result->fetch_assoc();
    $customer_id = $customer['id'];

    // Insert appointment into appointments table
    $appointment_date = $date . ' ' . $time;
    $created_at = date('Y-m-d H:i:s'); // Current timestamp
    $is_completed = 0; // New appointments are not completed

    $sql = "INSERT INTO appointments (customer_id, appointment_date, notes, created_at, is_completed)
            VALUES ('$customer_id', '$appointment_date', '$notes', '$created_at', '$is_completed')";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment booked successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Customer not found!";
}

$conn->close();
?>
