<?php
// submit_appointment.php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['customer_id'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $appointment_date = $_POST['appointment-date'] . ' ' . $_POST['appointment-time'];
    $message = $_POST['notes'];

    try {
        // Check if the date and time are available
        $stmt = $db->prepare("SELECT COUNT(*) FROM appointments WHERE appointment_date = :appointment_date");
        $stmt->bindParam(':appointment_date', $appointment_date, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo 'Date and time unavailable';
        } else {
            // Insert the appointment
            $stmt = $db->prepare("INSERT INTO appointments (name, email, phone, appointment_date, message) VALUES (:name, :email, :phone, :appointment_date, :message)");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            $stmt->bindParam(':appointment_date', $appointment_date, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->execute();

            echo 'success';
        }
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
}
