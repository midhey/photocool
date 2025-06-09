<?php
require_once __DIR__ . '/../core/config.php';
require_once __DIR__ . '/../core/db.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
  echo json_encode(['success' => false, 'errors' => ['Вы не авторизованы']]);
  exit;
}

$slot_id = intval($_POST['slot_id'] ?? 0);
$service_id = !empty($_POST['service_id']) ? intval($_POST['service_id']) : null;
$worker_id = !empty($_POST['worker_id']) ? intval($_POST['worker_id']) : null;
$phone = trim($_POST['phone'] ?? '');

if (!$phone || !preg_match('/^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/', $phone)) {
  echo json_encode(['success' => false, 'errors' => ['Укажите корректный номер телефона']]);
  exit;
}

if (!$slot_id) {
  echo json_encode(['success' => false, 'errors' => ['Слот не выбран']]);
  exit;
}

// Получаем дату/время слота
$stmt = $mysqli->prepare("SELECT datetime FROM slots WHERE id = ?");
$stmt->bind_param("i", $slot_id);
$stmt->execute();
$slot_result = $stmt->get_result();
$slot_data = $slot_result->fetch_assoc();
$stmt->close();

if (!$slot_data) {
  echo json_encode(['success' => false, 'errors' => ['Слот не найден']]);
  exit;
}

$datetime = $slot_data['datetime'];

// Проверка: слот уже забронирован?
$stmt = $mysqli->prepare("
  SELECT 1 FROM bookings 
  WHERE slot_id = ? AND status IN ('pending', 'confirmed')
  LIMIT 1
");
$stmt->bind_param("i", $slot_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  echo json_encode(['success' => false, 'errors' => ['Слот уже забронирован']]);
  exit;
}
$stmt->close();

// Проверка: фотограф занят в это время?
if ($worker_id) {
  $stmt = $mysqli->prepare("
    SELECT 1
    FROM bookings b
    JOIN slots s ON b.slot_id = s.id
    WHERE s.datetime = ? AND b.worker_id = ? AND b.status IN ('pending', 'confirmed')
    LIMIT 1
  ");
  $stmt->bind_param("si", $datetime, $worker_id);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'errors' => ['Фотограф уже занят в это время']]);
    exit;
  }
  $stmt->close();
}

/*// (опционально) проверка на занятую услугу:*/
/*if ($service_id) {*/
/*  $stmt = $mysqli->prepare("*/
/*    SELECT 1*/
/*    FROM bookings b*/
/*    JOIN slots s ON b.slot_id = s.id*/
/*    WHERE s.datetime = ? AND b.service_id = ? AND b.status IN ('pending', 'confirmed')*/
/*    LIMIT 1*/
/*  ");*/
/*  $stmt->bind_param("si", $datetime, $service_id);*/
/*  $stmt->execute();*/
/*  $stmt->store_result();*/
/**/
/*  if ($stmt->num_rows > 0) {*/
/*    echo json_encode(['success' => false, 'errors' => ['Услуга уже используется в это время']]);*/
/*    exit;*/
/*  }*/
/*  $stmt->close();*/
/*}*/

// Всё ок — создаём бронь
$stmt = $mysqli->prepare("
  INSERT INTO bookings (user_id, phone, slot_id, service_id, worker_id, status)
  VALUES (?, ?, ?, ?, ?, 'pending')
");
$stmt->bind_param("isiii", $user_id, $phone, $slot_id, $service_id, $worker_id);

$stmt->execute();

echo json_encode(['success' => true]);
