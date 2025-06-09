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

// Получаем текущий статус
$stmt = $mysqli->prepare("SELECT is_banned FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
  echo json_encode(['success' => false, 'error' => 'Пользователь не найден']);
  exit;
}

$new_status = !$user['is_banned'];

$stmt = $mysqli->prepare("UPDATE users SET is_banned = ? WHERE id = ?");
$stmt->bind_param("ii", $new_status, $user_id);
$success = $stmt->execute();
$stmt->close();

echo json_encode(['success' => $success]);
