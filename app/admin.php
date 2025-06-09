<?php
require_once __DIR__ . '/views/components/header.php';
require_once BASE_PATH . '/controllers/check_role.php';

if (!isset($_SESSION['user_id']) || check_role() !== 'admin') {
  header('Location: /404.php');
  exit;
}

require_once BASE_PATH . '/views/components/admin.php';
require_once BASE_PATH . '/views/components/footer.php';
