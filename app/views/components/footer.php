</main>
<footer class="bg-white mt-12 border-t">
  <div class="container mx-auto px-6 py-4 text-sm text-gray-500 text-center">
    &copy; <?= date('Y') ?> Фотостудия. Все права защищены.
  </div>
</footer>

<?php

require BASE_PATH . '/views/modals/login.php';
require BASE_PATH . '/views/modals/register.php';
require BASE_PATH . '/views/modals/booking.php';

?>

<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
<script src='../js/main.js' type="text/javascript"></script>
</body>

</html>
