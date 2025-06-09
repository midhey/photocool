<?php
require_once __DIR__ . '/../core/config.php';
require_once BASE_PATH . '/core/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['success' => false, 'error' => 'Метод не разрешен']);
  exit;
}

$user_id = intval($_POST['user_id'] ?? 0);

if (!$user_id) {
  echo json_encode(['success' => false, 'error' => 'ID пользователя не передан']);
  exit;
}

// Получаем текущую роль
$stmt = $mysqli->prepare("SELECT role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
  echo json_encode(['success' => false, 'error' => 'Пользователь не найден']);
  exit;
}

$new_role = $user['role'] === 'user' ? 'staff' : 'user';

$stmt = $mysqli->prepare("UPDATE users SET role = ? WHERE id = ?");
$stmt->bind_param("si", $new_role, $user_id);
$success = $stmt->execute();
$stmt->close();

echo json_encode(['success' => $success]);
