<?php
require_once __DIR__ . '/views/components/header.php';
require_once BASE_PATH . '/core/db.php';

?>

<div class="bg-white rounded-lg shadow p-4 mb-6">
  <h2 class="text-2xl font-semibold mb-2">🛠 Статус системы</h2>
  <ul class="space-y-1 text-sm text-gray-700">
    <li>DB_HOST: <code class="bg-gray-100 px-2 py-0.5 rounded"><?= DB_HOST ?></code></li>
    <li>DB_NAME: <code class="bg-gray-100 px-2 py-0.5 rounded"><?= DB_NAME ?></code></li>
    <li>
      <?php if ($mysqli->ping()): ?>
        <span class="text-green-600 font-medium">Подключение к MySQL установлено</span>
      <?php else: ?>
        <span class="text-red-600 font-medium">Ошибка подключения к MySQL</span>
      <?php endif; ?>
    </li>
  </ul>
</div>


<?php require_once BASE_PATH . '/views/components/footer.php'; ?>
