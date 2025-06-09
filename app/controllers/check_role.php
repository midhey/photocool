<?php
require_once BASE_PATH . '/core/db.php'; // добавь эту строку

function check_role(): ?string
{
  global $mysqli;

  if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
  }

  $user_id = $_SESSION['user_id'];
  $stmt = $mysqli->prepare("SELECT role FROM users WHERE id = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
  $stmt->close();

  return $user['role'] ?? null;
}
