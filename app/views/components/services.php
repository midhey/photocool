<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
  <h2 class="text-3xl font-bold text-gray-900 mb-8">Услуги, которые можно добавить к брони</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <?php foreach ($services as $service): ?>
      <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition flex flex-col">
        <div class="flex-grow">
          <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($service['title']) ?></h3>
          <p class="text-gray-600 text-sm leading-relaxed pb-4"><?= nl2br(htmlspecialchars($service['description'])) ?></p>
        </div>
        <p class="text-gray-800 font-bold pt-4 mt-auto border-t">от <?= number_format($service['price'], 0, ',', ' ') ?> ₽</p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
