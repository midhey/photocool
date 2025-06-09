<?php
require_once __DIR__ . '/../core/config.php';
require_once BASE_PATH . '/core/db.php';
require_once BASE_PATH . '/core/password.php';

header('Content-Type: application/json');

$errors = [];

$login = trim($_POST['login'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm'] ?? '';

if ($login === '' || $email === '' || $password === '') {
  $errors[] = 'Все поля обязательны';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'Некорректный email';
}

if ($password !== $confirm) {
  $errors[] = 'Пароли не совпадают';
}

if (empty($errors)) {
  $stmt = $mysqli->prepare("SELECT id FROM users WHERE login = ? OR email = ?");
  $stmt->bind_param("ss", $login, $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $errors[] = 'Пользователь с таким логином или email уже существует';
  }
  $stmt->close();
}

if (empty($errors)) {
  $hashed = hash_password($password);
  $stmt = $mysqli->prepare("INSERT INTO users (login, email, password) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $login, $email, $hashed);
  $stmt->execute();

  $_SESSION['user_id'] = $stmt->insert_id;
  $stmt->close();

  echo json_encode(['success' => true]);
  exit;
}

echo json_encode(['success' => false, 'errors' => $errors]);
exit;
