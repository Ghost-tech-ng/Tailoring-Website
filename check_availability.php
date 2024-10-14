<?php
// check_availability.php

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

$date = $_POST['date'] ?? '';

try {
    $stmt = $db->prepare("SELECT COUNT(*) FROM appointments WHERE appointment_date = :date");
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    echo $count > 0 ? 'unavailable' : 'available';
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
