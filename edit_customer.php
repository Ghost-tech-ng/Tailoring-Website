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

// Check if the ID is provided
if (!isset($_POST['id']) || empty($_POST['id'])) {
    $_SESSION['error'] = "No customer ID provided.";
    header("Location: customers.php");
    exit();
}

$customer_id = $_POST['id'];

// Fetch customer details
try {
    $stmt = $db->prepare("SELECT * FROM customers WHERE id = :id");
    $stmt->bindParam(':id', $customer_id, PDO::PARAM_INT);
    $stmt->execute();
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$customer) {
        $_SESSION['error'] = "Customer not found.";
        header("Location: customers.php");
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Error fetching customer details: " . $e->getMessage();
    header("Location: customers.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';
    $measurements = isset($_POST['measurements']) ? trim($_POST['measurements']) : '';
    $amount = isset($_POST['amount']) ? trim($_POST['amount']) : '';
    $date = isset($_POST['date']) ? trim($_POST['date']) : ''; // Added date field

    // Validate data
    if ($name && $contact) {
        try {
            // Prepare an update statement
            $stmt = $db->prepare("UPDATE customers SET name = :name, contact = :contact, measurements = :measurements, amount = :amount, date = :date WHERE id = :id");
            // Bind parameters
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
            $stmt->bindParam(':measurements', $measurements, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR); // Bind date parameter
            $stmt->bindParam(':id', $customer_id, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            // Redirect to the customers page with success message
            $_SESSION['message'] = "Customer updated successfully!";
            header("Location: customers.php");
            exit();
        } catch (PDOException $e) {
            // Display error message if query fails
            $_SESSION['error'] = "Error updating customer: " . $e->getMessage();
            header("Location: customers.php");
            exit();
        }
    } else {
        // Redirect back to the customers page with an error message if validation fails
        $_SESSION['error'] = "Please fill in all required fields.";
        header("Location: customers.php");
        exit();
    }
}
?>
