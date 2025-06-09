<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
  <h1 class="text-3xl font-bold mb-6">Мои бронирования</h1>

  <?php if (empty($bookings)): ?>
    <p class="text-gray-600">У вас пока нет активных бронирований.</p>
  <?php else: ?>
    <div class="space-y-6">
      <?php foreach ($bookings as $booking): ?>
        <div class="bg-white shadow rounded-lg p-5 border border-gray-200">
          <div class="flex justify-between items-center mb-2">
            <h2 class="text-xl font-semibold">
              <?= htmlspecialchars($booking['location_name'] ?? '— Локация удалена —') ?>
            </h2>
            <span class="text-sm px-2 py-1 rounded 
              <?= match ($booking['status']) {
                'pending' => 'bg-yellow-100 text-yellow-800',
                'confirmed' => 'bg-green-100 text-green-800',
                'cancelled' => 'bg-red-100 text-red-800',
                default => 'bg-gray-100 text-gray-800'
              } ?>">
              <?= match ($booking['status']) {
                'pending' => 'На подтверждении',
                'confirmed' => 'Подтверждено',
                'cancelled' => 'Отменено',
                default => ucfirst($booking['status'])
              } ?>
            </span>
          </div>
          <p class="text-gray-700 mb-1"><strong>Дата и время:</strong> <?= date('d.m.Y H:i', strtotime($booking['datetime'])) ?></p>
          <?php if ($booking['service_title']): ?>
            <p class="text-gray-700"><strong>Услуга:</strong> <?= htmlspecialchars($booking['service_title']) ?></p>
          <?php endif; ?>
          <?php if ($booking['worker_name']): ?>
            <p class="text-gray-700"><strong>Фотограф:</strong> <?= htmlspecialchars($booking['worker_name']) ?></p>
          <?php endif; ?>

          <div class="flex justify-between items-end mt-4">
            <p class="text-gray-500 text-sm">Создано: <?= date('d.m.Y H:i', strtotime($booking['created_at'])) ?></p>
            <?php if (in_array($booking['status'], ['pending', 'confirmed'])): ?>
              <button
                onclick="cancelBooking(<?= $booking['booking_id'] ?>)"
                class="text-sm text-red-600 border border-red-200 hover:border-red-500 hover:bg-red-50 px-3 py-1 rounded transition-all">
                Отменить бронирование
              </button>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>
