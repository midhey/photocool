<div id="bookingModal" class="fixed inset-0 bg-black/50 hidden z-50">
  <div class="flex items-center justify-center h-full">
    <div class="bg-white rounded-lg p-6 w-full max-w-xl relative">
      <button onclick="closeBookingModal()" class="absolute top-2 right-2 text-gray-500 text-xl">&times;</button>

      <h2 class="text-2xl font-bold mb-4">Забронировать студию</h2>

      <form id="bookingForm" class="space-y-4">
        <input type="hidden" name="location_id" id="bookingLocationId">

        <div>
          <label class="block font-medium mb-1">Выберите слот</label>
          <select name="slot_id" id="slotSelect" class="w-full border rounded p-2" required></select>
        </div>

        <div>
          <label class="block font-medium mb-1">Доп. услуга (необязательно)</label>
          <select name="service_id" id="serviceSelect" class="w-full border rounded p-2">
            <option value="">— Не выбрано —</option>
            <?php foreach ($services as $service): ?>
              <option value="<?= $service['id'] ?>"><?= htmlspecialchars($service['title']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label class="block font-medium mb-1">Фотограф (необязательно)</label>
          <select name="worker_id" id="workerSelect" class="w-full border rounded p-2">
            <option value="">— Не выбран —</option>
            <?php foreach ($workers as $worker): ?>
              <option value="<?= $worker['id'] ?>"><?= htmlspecialchars($worker['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label class="block font-medium mb-1">Ваш телефон</label>
          <input
            type="tel"
            name="phone"
            id="phoneInput"
            class="w-full border rounded p-2"
            required
            placeholder="+7 (___) ___-__-__"
            pattern="\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}"
            title="Формат: +7 (999) 123-45-67">
        </div>
        <div id="bookingErrors" class="text-red-600 text-sm hidden"></div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
          Забронировать
        </button>
      </form>
    </div>
  </div>
</div>
