<?php
require_once __DIR__ . '/../core/config.php';
require_once BASE_PATH . '/core/db.php';
require_once BASE_PATH . '/core/password.php';

header('Content-Type: application/json');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $login = trim($_POST['login'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($login === '' || $password === '') {
    $errors[] = 'Заполните все поля';
  } else {
    $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE login = ? OR email = ?");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
      if (verify_password($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        echo json_encode(['success' => true]);
        exit;
      } else {
        $errors[] = 'Неверный пароль';
      }
    } else {
      $errors[] = 'Пользователь не найден';
    }

    $stmt->close();
  }
}

echo json_encode(['success' => false, 'errors' => $errors]);
exit;
