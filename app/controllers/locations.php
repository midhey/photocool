<?php
require_once BASE_PATH . '/core/db.php';

$stmt = $mysqli->prepare("SELECT id, name, address, image_url FROM locations ORDER BY id ASC");
$stmt->execute();
$result = $stmt->get_result();
$locations = $result->fetch_all(MYSQLI_ASSOC);

require_once BASE_PATH . '/views/components/locations.php';
