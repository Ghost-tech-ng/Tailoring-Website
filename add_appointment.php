<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

// Database credentials
$host = 'localhost';
$dbname = 'u604612450_josh';
$user = 'u604612450_josh';
$pass = 'Joshuaweb123.';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = trim($_POST['customer_id']);
    $appointment_date = trim($_POST['appointment_date']);
    $notes = trim($_POST['notes']);

    if ($customer_id && $appointment_date) {
        try {
            $stmt = $db->prepare("INSERT INTO appointments (customer_id, appointment_date, notes) VALUES (:customer_id, :appointment_date, :notes)");
            $stmt->bindParam(':customer_id', $customer_id);
            $stmt->bindParam(':appointment_date', $appointment_date);
            $stmt->bindParam(':notes', $notes);
            $stmt->execute();
            header("Location: appointments.php");
            exit();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        echo "Customer ID and Appointment Date are required.";
    }
}
?>
