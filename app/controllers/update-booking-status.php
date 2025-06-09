<?php
require_once __DIR__ . '/../core/config.php';
require_once BASE_PATH . '/core/db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: /index.php');
  exit;
}
require_once BASE_PATH . '/controllers/check_role.php';
if (check_role() !== 'admin' && check_role() !== 'staff') {
  http_response_code(403);
  echo json_encode(['error' => 'Доступ запрещён']);
  exit;
}

$booking_id = intval($_POST['booking_id'] ?? 0);
$status = $_POST['status'] ?? '';

if (!in_array($status, ['confirmed', 'cancelled'])) {
  echo json_encode(['success' => false, 'error' => 'Недопустимый статус']);
  exit;
}

$stmt = $mysqli->prepare("UPDATE bookings SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $booking_id);
$stmt->execute();

echo json_encode(['success' => true]);
