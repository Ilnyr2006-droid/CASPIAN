cat > /var/www/CASPIAN/admin/dashboard.php <<'PHP'
<?php
declare(strict_types=1);
require __DIR__ . '/auth.php';
require_auth();

require __DIR__ . '/lib_storage.php';
require __DIR__ . '/ui.php';

admin_header('Дашборд', 'dashboard');

$files = allowed_data_files();
?>
<div class="grid">
  <div class="card">
    <h3 style="margin:0 0 10px 0;">Разделы</h3>
    <div class="files">
      <span class="chip">Товары → products.json</span>
      <span class="chip">Новости → news.json</span>
      <span class="chip">Проекты → projects.json</span>
      <span class="chip">Медиа → uploads/</span>
    </div>
    <p class="muted">Админка валидирует JSON и делает бэкап перед сохранением.</p>
  </div>

  <div class="card">
    <h3 style="margin:0 0 10px 0;">Проверка доступов</h3>
    <p class="muted">Если “Сохранить” не работает — значит нет прав на /data или /uploads.</p>
    <p>Папка data: <b><?= is_writable(data_dir()) ? 'запись разрешена' : 'нет прав на запись' ?></b></p>
    <p>Папка uploads: <b><?= is_writable(uploads_dir()) ? 'запись разрешена' : 'нет прав на запись' ?></b></p>
  </div>
</div>

<div class="card" style="margin-top:14px;">
  <h3 style="margin:0 0 10px 0;">Быстрые ссылки</h3>
  <p><a class="link" href="/admin/products.php">Открыть товары</a></p>
  <p><a class="link" href="/admin/news.php">Открыть новости</a></p>
  <p><a class="link" href="/admin/projects.php">Открыть проекты</a></p>
  <p><a class="link" href="/admin/media.php">Загрузить фото</a></p>
</div>
<?php admin_footer(); ?>
PHP
