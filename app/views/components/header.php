<?php
require_once __DIR__ . '/../../core/config.php';
require_once BASE_PATH . '/controllers/check_role.php';
$is_logged_in = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <title>Фотостудия</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<script>
  const IS_AUTHENTICATED = <?= isset($_SESSION['user_id']) ? 'true' : 'false' ?>;
</script>

<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">

  <header class="bg-white shadow">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <a href="/index.php" class="text-xl font-bold text-gray-800 hover:text-blue-600">📸 Фотостудия</a>

      <nav class="space-x-4">
        <?php if ($is_logged_in): ?>
          <?php if (check_role() == 'admin'): ?>
            <a href="/admin.php" class="text-gray-700 hover:text-blue-600">Админка</a>
          <?php endif; ?>
          <?php if (check_role() == 'admin' || check_role() == 'staff'): ?>
            <a href="/manager.php" class="text-gray-700 hover:text-blue-600">Кабинет менеджера</a>
          <?php endif; ?>
          <a href="/dashboard.php" class="text-gray-700 hover:text-blue-600">Личный кабинет</a>
          <a href="#" onclick="handleLogout(event)" class="text-red-600 hover:underline">Выход</a>
        <?php else: ?>
          <button
            type="button"
            data-te-toggle="modal"
            data-te-target="#loginModal"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Вход
          </button>
          <button
            type="button"
            data-te-toggle="modal"
            data-te-target="#registerModal"
            class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
            Регистрация
          </button>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main class="container mx-auto p-6 flex-grow">
