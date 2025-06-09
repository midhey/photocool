<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
  <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Аренда фотостудий</h1>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php foreach ($locations as $location): ?>
      <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition overflow-hidden">
        <img src="<?= htmlspecialchars($location['image_url']) ?>"
          alt="<?= htmlspecialchars($location['name']) ?>"
          class="w-full h-64 object-cover">
        <div class="p-5">
          <h2 class="text-2xl font-bold mb-1"><?= htmlspecialchars($location['name']) ?></h2>
          <a href="#" onclick="handleOpenBookingModal(<?= $location['id'] ?>)" class="text-blue-600 hover:underline">
            Забронировать →
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
