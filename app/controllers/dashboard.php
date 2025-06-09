<?php
require_once BASE_PATH . '/core/db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: /index.php');
  exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("
    SELECT 
        bookings.id AS booking_id,
        bookings.status,
        bookings.created_at,
        slots.datetime,
        locations.name AS location_name,
        services.title AS service_title,
        workers.name AS worker_name
    FROM bookings
    JOIN slots ON bookings.slot_id = slots.id
    LEFT JOIN locations ON slots.location_id = locations.id
    LEFT JOIN services ON bookings.service_id = services.id
    LEFT JOIN workers ON bookings.worker_id = workers.id
    WHERE bookings.user_id = ?
    ORDER BY bookings.created_at DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

require_once BASE_PATH . '/views/components/dashboard.php';
