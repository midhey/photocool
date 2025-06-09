<?php
require_once '../core/config.php';
require_once '../core/db.php';

$result = $mysqli->query("SELECT id, login, email, role, is_banned, created_at FROM users");
$users = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode(['users' => $users]);
