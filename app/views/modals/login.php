<div
  data-te-modal-init
  class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden bg-black/50"
  id="loginModal"
  tabindex="-1"
  aria-hidden="true"
>
  <div
    data-te-modal-dialog-ref
    class="pointer-events-none relative w-auto translate-y-[-50px] transition-all duration-300 ease-in-out mx-auto mt-8 max-w-md"
  >
    <div class="pointer-events-auto relative flex flex-col rounded-md bg-white p-6 shadow-lg outline-none">
      <div class="flex items-center justify-between border-b pb-3">
        <h5 class="text-xl font-medium leading-normal">Вход</h5>
        <button
          type="button"
          class="text-black text-2xl hover:opacity-75"
          data-te-modal-dismiss
        >&times;</button>
      </div>

      <form method="POST" onsubmit="handleLogin(event)" class="mt-4 space-y-4" id="loginForm">
        <div id="loginErrors" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded text-sm"></div>

        <div>
          <label for="login" class="block text-sm font-medium mb-1">Логин или Email</label>
          <input type="text" name="login" id="login" required
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-500" />
        </div>

        <div>
          <label for="password" class="block text-sm font-medium mb-1">Пароль</label>
          <input type="password" name="password" id="password" required
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-500" />
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Войти
        </button>
      </form>
    </div>
  </div>
</div>
