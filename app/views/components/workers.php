<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 mb-20">
  <h2 class="text-3xl font-bold text-gray-900 mb-8">Профессиональные фотографы</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php foreach ($workers as $worker): ?>
      <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition">
        <div class="h-60 w-full overflow-hidden">
          <img src="<?= htmlspecialchars($worker['image_url']) ?>"
            alt="<?= htmlspecialchars($worker['name']) ?>"
            class="w-full h-full object-cover">
        </div>
        <div class="p-5">
          <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($worker['name']) ?></h3>
          <p class="text-gray-600 text-sm"><?= nl2br(htmlspecialchars($worker['bio'])) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
