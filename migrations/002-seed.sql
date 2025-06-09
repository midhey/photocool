SET NAMES 'utf8mb4';
SET CHARACTER SET utf8mb4;

INSERT INTO users (login, email, password, role)
VALUES 
('admin', 'admin@studio.local', '$2y$10$zvN6cjJZMYUGN1rxeJ5Ez..WupT7MnDk6Eu4YJUiwAmljwhWiww4y', 'admin'),
('anna_kovalenko', 'anna.kovalenko@yandex.ru', '$2y$10$zvN6cjJZMYUGN1rxeJ5Ez..WupT7MnDk6Eu4YJUiwAmljwhWiww4y', 'staff'),
('dmitry_petrov', 'dmitry.petrov@yandex.ru', '$2y$10$zvN6cjJZMYUGN1rxeJ5Ez..WupT7MnDk6Eu4YJUiwAmljwhWiww4y', 'user'),
('elena_ivanova', 'elena.ivanova@yandex.ru', '$2y$10$zvN6cjJZMYUGN1rxeJ5Ez..WupT7MnDk6Eu4YJUiwAmljwhWiww4y', 'user'),
('maksim_smirnov', 'maksim.smirnov@yandex.ru', '$2y$10$zvN6cjJZMYUGN1rxeJ5Ez..WupT7MnDk6Eu4YJUiwAmljwhWiww4y', 'user'),
('natalia_egorova', 'natalia.egorova@yandex.ru', '$2y$10$zvN6cjJZMYUGN1rxeJ5Ez..WupT7MnDk6Eu4YJUiwAmljwhWiww4y', 'user'),
('andrey_zhukov', 'andrey.zhukov@yandex.ru', '$2y$10$zvN6cjJZMYUGN1rxeJ5Ez..WupT7MnDk6Eu4YJUiwAmljwhWiww4y', 'user'),
('irina_fedorova', 'irina.fedorova@yandex.ru', '$2y$10$zvN6cjJZMYUGN1rxeJ5Ez..WupT7MnDk6Eu4YJUiwAmljwhWiww4y', 'user'),
('sergey_volkov', 'sergey.volkov@yandex.ru', '$2y$10$zvN6cjJZMYUGN1rxeJ5Ez..WupT7MnDk6Eu4YJUiwAmljwhWiww4y', 'user'),
('maria_romanova', 'maria.romanova@yandex.ru', '$2y$10$zvN6cjJZMYUGN1rxeJ5Ez..WupT7MnDk6Eu4YJUiwAmljwhWiww4y', 'user'),
('alexey_grigoriev', 'alexey.grigoriev@yandex.ru', '$2y$10$zvN6cjJZMYUGN1rxeJ5Ez..WupT7MnDk6Eu4YJUiwAmljwhWiww4y', 'user');

INSERT INTO services (title, description, price, duration_minutes)
VALUES 
  ('Портретная съёмка', 'Профессиональная портретная фотосессия в студии', 3000.00, 60),
  ('Семейная фотосессия', 'Съёмка для всей семьи в уютной атмосфере', 4500.00, 90),
  ('Каталожная съёмка', 'Фотосъёмка товаров для маркетплейсов', 5000.00, 120),
  ('Love Story', 'Романтическая фотосессия для пары', 4000.00, 60),
  ('Детская фотосессия', 'Яркие кадры для вашего малыша', 3500.00, 45);

INSERT INTO locations (name, address, description, image_url)
VALUES 
  ('Белая студия', 'ул. Светлая, 1', 'Светлая студия в минимализме', 'https://topstudios.ru/wp-content/uploads/2016/09/2016-09-29_13-24-57.jpg'),
  ('Лофт зона', 'ул. Кирпичная, 12', 'Индустриальный стиль с кирпичными стенами', 'https://letmebel.ru/upload/iblock/5a8/vd7c0yx1tr4c89rvgbdjo4zsponyltix.jpg'),
  ('Прованс', 'ул. Лавандовая, 7', 'Нежная зона в стиле Прованс', 'https://burobiz-a.akamaihd.net/uploads/images/44346/large_image.jpeg');

INSERT INTO workers (name, bio, image_url)
VALUES 
  ('Иван Иванов', '10 лет в портретной и предметной съёмке', 'https://i.pinimg.com/originals/a0/07/75/a00775036bc19a2de0082cc40e862046.jpg'),
  ('Мария Смирнова', 'Специалист по детским и семейным фотосессиям', 'https://i.pinimg.com/736x/55/b4/f6/55b4f68eaa32131a1796ff03c36278d6.jpg'),
  ('Олег Петров', 'Фотограф каталожной и интерьерной съёмки', 'https://thumbs.dreamstime.com/b/мужской-фотограф-фотографируя-63973667.jpg');

INSERT INTO slots (datetime, location_id)
VALUES
  ('2025-06-08 10:00:00', 1),
  ('2025-06-08 12:00:00', 2),
  ('2025-06-08 15:00:00', 2),

  ('2025-06-09 09:30:00', 3),
  ('2025-06-09 13:00:00', 1),
  ('2025-06-09 16:00:00', 1),

  ('2025-06-10 11:00:00', 2),
  ('2025-06-10 13:30:00', 3),
  ('2025-06-10 16:30:00', 3),

  ('2025-06-11 10:00:00', 1),
  ('2025-06-11 12:00:00', 2),
  ('2025-06-11 15:00:00', 3),

  ('2025-06-12 10:30:00', 3),
  ('2025-06-12 13:00:00', 2),
  ('2025-06-12 16:00:00', 1),

  ('2025-06-13 09:00:00', 1),
  ('2025-06-13 11:30:00', 3),
  ('2025-06-13 14:30:00', 2),

  ('2025-06-14 10:00:00', 1),
  ('2025-06-14 13:00:00', 2),
  ('2025-06-14 15:30:00', 3);
