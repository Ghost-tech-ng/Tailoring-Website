<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Secure login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database credentials
$host = 'localhost';
$dbname = 'u604612450_josh';
$user = 'u604612450_josh';
$pass = 'Joshuaweb123.';

try {
    // Create a new PDO instance
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display error message if connection fails
    die("Connection failed: " . htmlspecialchars($e->getMessage()));
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data with trim and filter input to prevent XSS attacks
    $name = isset($_POST['name']) ? trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING)) : '';
    $contact = isset($_POST['contact']) ? trim(filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_STRING)) : '';
    $measurements = isset($_POST['measurements']) ? trim(filter_input(INPUT_POST, 'measurements', FILTER_SANITIZE_STRING)) : '';
    $amount = isset($_POST['amount']) ? trim(filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_STRING)) : '';
    $date = isset($_POST['date']) ? trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING)) : ''; // Added date field

    // Validate data
    if (!empty($name) && !empty($contact)) {
        try {
            // Prepare an insert statement
            $stmt = $db->prepare("INSERT INTO customers (name, contact, measurements, amount, date) VALUES (:name, :contact, :measurements, :amount, :date)");
            // Bind parameters
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
            $stmt->bindParam(':measurements', $measurements, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR); // Bind date parameter

            // Execute the statement
            $stmt->execute();

            // Redirect to the customers page with success message
            $_SESSION['message'] = "Customer added successfully!";
            header("Location: customers.php");
            exit();
        } catch (PDOException $e) {
            // Log the error message for debugging (optional)
            error_log("Error adding customer: " . $e->getMessage());

            // Display a generic error message to the user
            $_SESSION['error'] = "Error adding customer. Please try again later.";
            header("Location: customers.php");
            exit();
        }
    } else {
        // Redirect back to the customers page with an error message if validation fails
        $_SESSION['error'] = "Please fill in all required fields.";
        header("Location: customers.php");
        exit();
    }
} else {
    // Redirect to the customers page if accessed directly
    header("Location: customers.php");
    exit();
}
?>
