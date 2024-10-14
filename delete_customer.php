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
    // Get the customer ID from the form submission
    $customer_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($customer_id > 0) {
        try {
            // Prepare the delete statement
            $stmt = $db->prepare("DELETE FROM customers WHERE id = :id");
            // Bind the customer ID parameter
            $stmt->bindParam(':id', $customer_id, PDO::PARAM_INT);
            // Execute the statement
            $stmt->execute();

            // Redirect to the customers page with a success message
            $_SESSION['message'] = "Customer deleted successfully!";
            header("Location: customers.php");
            exit();
        } catch (PDOException $e) {
            // Log the error message for debugging (optional)
            error_log("Error deleting customer: " . $e->getMessage());

            // Display a generic error message to the user
            $_SESSION['error'] = "Error deleting customer. Please try again later.";
            header("Location: customers.php");
            exit();
        }
    } else {
        // Redirect back to the customers page with an error message if ID is invalid
        $_SESSION['error'] = "Invalid customer ID.";
        header("Location: customers.php");
        exit();
    }
} else {
    // Redirect to the customers page if accessed directly
    header("Location: customers.php");
    exit();
}
