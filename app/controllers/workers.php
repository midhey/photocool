<?php
require_once BASE_PATH . '/core/db.php';

$stmt = $mysqli->prepare("SELECT id, name, bio, image_url FROM workers ORDER BY id ASC");
$stmt->execute();
$result = $stmt->get_result();
$workers = $result->fetch_all(MYSQLI_ASSOC);

require_once BASE_PATH . '/views/components/workers.php';
