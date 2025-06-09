async function handleLogin(e) {
  e.preventDefault();

  const form = document.getElementById('loginForm');
  const errorsBox = document.getElementById('loginErrors');
  const formData = new FormData(form);

  const res = await fetch('/controllers/login.php', {
    method: 'POST',
    body: formData,
  });

  const data = await res.json();

  if (data.success) {
    window.location.reload();
  } else {
    errorsBox.innerHTML = `<ul class="list-disc pl-4">${data.errors.map(err => `<li>${err}</li>`).join('')}</ul>`;
    errorsBox.classList.remove('hidden');
  }
}

async function handleRegister(e) {
  e.preventDefault();

  const form = document.getElementById('registerForm');
  const errorsBox = document.getElementById('registerErrors');
  const formData = new FormData(form);

  const res = await fetch('/controllers/register.php', {
    method: 'POST',
    body: formData,
  });

  const data = await res.json();

  if (data.success) {
    window.location.reload();
  } else {
    errorsBox.innerHTML = `<ul class="list-disc pl-4">${data.errors.map(err => `<li>${err}</li>`).join('')}</ul>`;
    errorsBox.classList.remove('hidden');
  }
}

async function handleLogout(e) {
  e.preventDefault();

  try {
    const res = await fetch('/controllers/logout.php', {
      method: 'POST',
    });

    const data = await res.json();

    if (data.success) {
      window.location.reload();
    }
  } catch (err) {
    console.error('Ошибка при выходе:', err);
  }
}

async function handleOpenBookingModal(locationId) {
  if (!IS_AUTHENTICATED) {
    alert('Для бронирования необходимо войти в аккаунт.');
    const loginModal = document.getElementById('loginModal');
    if (loginModal) loginModal.classList.remove('hidden');
    return;
  }

  const modal = document.getElementById('bookingModal');
  const slotSelect = document.getElementById('slotSelect');
  const locationInput = document.getElementById('bookingLocationId');
  const errorBox = document.getElementById('bookingErrors');
  const form = document.getElementById('bookingForm');

  slotSelect.innerHTML = '<option>Загрузка...</option>';
  errorBox.classList.add('hidden');
  errorBox.innerHTML = '';
  locationInput.value = locationId;
  modal.classList.remove('hidden');

  try {
    const res = await fetch(`/controllers/get-slots.php?location_id=${locationId}`);
    const data = await res.json();

    slotSelect.innerHTML = '';
    if (data.slots.length > 0) {
      data.slots.forEach(slot => {
        const option = document.createElement('option');
        option.value = slot.id;
        option.textContent = new Date(slot.datetime).toLocaleString();
        slotSelect.appendChild(option);
      });
    } else {
      slotSelect.innerHTML = '<option disabled>Нет доступных слотов</option>';
    }
  } catch (err) {
    slotSelect.innerHTML = '<option disabled>Ошибка загрузки</option>';
    console.error('Ошибка загрузки слотов:', err);
  }

  form.onsubmit = async function (e) {
    e.preventDefault();

    const formData = new FormData(form);
    const res = await fetch('/controllers/book-slot.php', {
      method: 'POST',
      body: formData,
    });

    const result = await res.json();

    if (result.success) {
      modal.classList.add('hidden');
      alert("Заявка успешно отправлена!");
    } else {
      errorBox.innerHTML = `<ul class="list-disc pl-4">${result.errors.map(e => `<li>${e}</li>`).join('')}</ul>`;
      errorBox.classList.remove('hidden');
    }
  };
}

function closeBookingModal() {
  document.getElementById('bookingModal').classList.add('hidden');
}

async function cancelBooking(bookingId) {
  if (!confirm('Вы уверены, что хотите отменить бронирование?')) return;

  const res = await fetch('/controllers/cancel-booking.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ booking_id: bookingId })
  });

  const data = await res.json();

  if (data.success) {
    location.reload();
  } else {
    alert(data.errors?.join('\n') || 'Произошла ошибка при отмене.');
  }
}

async function loadBookings() {
  const res = await fetch('/controllers/get-bookings.php');
  const { bookings } = await res.json();
  const container = document.getElementById('bookingList');
  container.innerHTML = '';

  bookings.forEach(b => {
    const card = document.createElement('div');
    card.className = 'bg-white p-4 rounded shadow border';

    card.innerHTML = `
      <div class="flex justify-between items-center">
        <div>
          <h2 class="text-lg font-semibold">${b.location_name || '—'}</h2>
          <p><strong>Дата:</strong> ${new Date(b.datetime).toLocaleString()}</p>
          <p><strong>Клиент:</strong> ${b.login} (${b.email})</p>
          ${b.service_title ? `<p><strong>Услуга:</strong> ${b.service_title}</p>` : ''}
          ${b.worker_name ? `<p><strong>Фотограф:</strong> ${b.worker_name}</p>` : ''}
          ${b.phone ? `<a href="tel:${b.phone}"><strong class="text-3xl"> ${b.phone} </strong></a>`: ''}
        </div>
        <div class="text-sm text-gray-600">
          <span class="block mb-2">${statusLabel(b.status)}</span>
          ${b.status === 'pending' ? `
            <button onclick="updateStatus(${b.booking_id}, 'confirmed')" class="px-3 py-1 bg-green-500 text-white rounded mr-2">Подтвердить</button>
            <button onclick="updateStatus(${b.booking_id}, 'cancelled')" class="px-3 py-1 bg-red-500 text-white rounded">Отклонить</button>
          ` : ''}
        </div>
      </div>
    `;

    container.appendChild(card);
  });
}

function statusLabel(status) {
  switch (status) {
    case 'pending':
      return `
        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-sm font-medium bg-yellow-100 text-yellow-800">
          На подтверждении
        </span>
      `;
    case 'confirmed':
      return `
        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-sm font-medium bg-green-100 text-green-800">
          Подтверждено
        </span>
      `;
    case 'cancelled':
      return `
        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-sm font-medium bg-red-100 text-red-800">
          Отменено
        </span>
      `;
    default:
      return `
        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-sm font-medium bg-gray-100 text-gray-800">
          ${status}
        </span>
      `;
  }
}

async function updateStatus(id, status) {
  const res = await fetch('/controllers/update-booking-status.php', {
    method: 'POST',
    body: new URLSearchParams({ booking_id: id, status })
  });
  const result = await res.json();
  if (result.success) loadBookings();
  else alert(result.error || 'Ошибка изменения статуса');
}

const phoneInput = document.getElementById('phoneInput');
if (phoneInput) {
  IMask(phoneInput, {
    mask: '+{7} (000) 000-00-00'
  });
}

async function loadUsers() {
  const res = await fetch('/controllers/get-users.php');
  const data = await res.json();
  const users = data.users;

  const table = document.createElement('table');
  table.className = "min-w-full text-sm text-left text-gray-700";

  const thead = `
    <thead class="bg-gray-100">
      <tr>
        <th class="px-4 py-2">ID</th>
        <th class="px-4 py-2">Логин</th>
        <th class="px-4 py-2">Email</th>
        <th class="px-4 py-2">Роль</th>
        <th class="px-4 py-2">Статус</th>
        <th class="px-4 py-2">Действия</th>
      </tr>
    </thead>
  `;

  const tbody = document.createElement('tbody');

  users.forEach(user => {
    const row = document.createElement('tr');
    row.className = "border-t";

    const isBanned = user.is_banned == 1;

    row.innerHTML = `
      <td class="px-4 py-2">${user.id}</td>
      <td class="px-4 py-2">${user.login}</td>
      <td class="px-4 py-2">${user.email}</td>
      <td class="px-4 py-2">${user.role}</td>
      <td class="px-4 py-2">
        ${isBanned 
          ? '<span class="text-red-600 font-semibold">Забанен</span>' 
          : '<span class="text-green-600">Активен</span>'}
      </td>
      <td class="px-4 py-2 space-x-2">
        <button onclick="toggleRole(${user.id})"
          class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs">
          ${user.role === 'user' ? 'Назначить сотрудником' : 'Сделать пользователем'}
        </button>
        <button onclick="toggleBan(${user.id})"
          class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs">
          ${isBanned ? 'Разбанить' : 'Забанить'}
        </button>
      </td>
    `;
    tbody.appendChild(row);
  });

  table.innerHTML = thead;
  table.appendChild(tbody);

  document.getElementById('usersTable').innerHTML = '';
  document.getElementById('usersTable').appendChild(table);
}

async function toggleRole(userId) {
  const res = await fetch(`/controllers/update-user-role.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `user_id=${userId}`
  });
  const data = await res.json();
  if (data.success) {
    loadUsers();
  } else {
    alert('Ошибка при смене роли');
  }
}

async function toggleBan(userId) {
  const res = await fetch(`/controllers/toggle-ban-user.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `user_id=${userId}`
  });
  const data = await res.json();
  if (data.success) {
    loadUsers();
  } else {
    alert('Ошибка при обновлении статуса');
  }
}
