<?php
require_once __DIR__ . '/../core/config.php';
require_once __DIR__ . '/../core/db.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
  echo json_encode(['success' => false, 'errors' => ['Вы не авторизованы']]);
  exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$booking_id = intval($input['booking_id'] ?? 0);

if (!$booking_id) {
  echo json_encode(['success' => false, 'errors' => ['Некорректный ID брони']]);
  exit;
}

// Обновим статус только своей брони
$stmt = $mysqli->prepare("
  UPDATE bookings 
  SET status = 'cancelled' 
  WHERE id = ? AND user_id = ? AND status IN ('pending', 'confirmed')
");
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'errors' => ['Бронирование не найдено или уже отменено']]);
}
