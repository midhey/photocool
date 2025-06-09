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

$stmt = $mysqli->prepare("
  SELECT 
    b.id AS booking_id,
    b.status,
    b.created_at,
    b.phone,
    u.login,
    u.email,
    s.datetime,
    l.name AS location_name,
    srv.title AS service_title,
    w.name AS worker_name
  FROM bookings b
  JOIN users u ON b.user_id = u.id
  JOIN slots s ON b.slot_id = s.id
  LEFT JOIN locations l ON s.location_id = l.id
  LEFT JOIN services srv ON b.service_id = srv.id
  LEFT JOIN workers w ON b.worker_id = w.id
  ORDER BY b.created_at DESC
");

$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode(['bookings' => $bookings]);
