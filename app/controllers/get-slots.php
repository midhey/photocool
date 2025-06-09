<?php
require_once __DIR__ . '/../core/config.php';
require_once __DIR__ . '/../core/db.php';

$location_id = intval($_GET['location_id'] ?? 0);

$stmt = $mysqli->prepare("
  SELECT s.id, s.datetime 
  FROM slots s
  LEFT JOIN bookings b ON b.slot_id = s.id AND b.status IN ('pending', 'confirmed')
  WHERE s.location_id = ? AND b.id IS NULL
  ORDER BY s.datetime ASC
");
$stmt->bind_param("i", $location_id);
$stmt->execute();

$result = $stmt->get_result();
$slots = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode(['slots' => $slots]);
