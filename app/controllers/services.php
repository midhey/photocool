<?php
require_once BASE_PATH . '/core/db.php';

$stmt = $mysqli->prepare("SELECT id, title, description, price FROM services ORDER BY id ASC LIMIT 6");
$stmt->execute();
$result = $stmt->get_result();
$services = $result->fetch_all(MYSQLI_ASSOC);

require_once BASE_PATH . '/views/components/services.php';
