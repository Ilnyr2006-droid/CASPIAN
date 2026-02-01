<?php
declare(strict_types=1);
require __DIR__ . '/auth.php';
require_auth();

require __DIR__ . '/lib_storage.php';
require __DIR__ . '/ui.php';

$msgOk = '';
$msgErr = '';

$dir = uploads_dir();
if (!is_dir($dir)) @mkdir($dir, 0775, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    $msgErr = 'Ошибка загрузки файла';
  } else {
    $name = basename((string)$_FILES['file']['name']);
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp','gif','svg','pdf'];
    if (!in_array($ext, $allowed, true)) {
      $msgErr = 'Недопустимый тип файла';
    } else {
      $safe = preg_replace('/[^a-zA-Z0-9._-]+/', '-', $name);
      $target = rtrim($dir, '/') . '/' . $safe;
      if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        @chmod($target, 0664);
        $msgOk = 'Файл загружен: /uploads/' . $safe;
      } else {
        $msgErr = 'Не удалось сохранить файл (проверь права на uploads)';
      }
    }
  }
}

$files = [];
if (is_dir($dir)) {
  $all = scandir($dir) ?: [];
  foreach ($all as $f) {
    if ($f === '.' || $f === '..') continue;
    if (is_file($dir . '/' . $f)) $files[] = $f;
  }
  sort($files);
}

admin_header('Медиа (uploads/)', 'media');
?>
<div class="card">
  <p class="muted">Загружай изображения/файлы. Потом указывай имя файла в поле <b>image</b> в products.json.</p>

  <?php if ($msgOk): ?><div class="msg-ok"><?= htmlspecialchars($msgOk) ?></div><?php endif; ?>
  <?php if ($msgErr): ?><div class="msg-err"><?= htmlspecialchars($msgErr) ?></div><?php endif; ?>

  <form method="post" enctype="multipart/form-data" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
    <input type="file" name="file" required>
    <button type="submit">Загрузить</button>
  </form>
</div>

<div class="card" style="margin-top:14px;">
  <h3 style="margin:0 0 10px 0;">Файлы в /uploads</h3>
  <?php if (!$files): ?>
    <p class="muted">Пока пусто.</p>
  <?php else: ?>
    <div class="files">
      <?php foreach ($files as $f): ?>
        <span class="chip"><?= htmlspecialchars($f) ?></span>
      <?php endforeach; ?>
    </div>
    <p class="muted" style="margin-top:10px;">Путь для сайта: <b>/uploads/ИМЯ_ФАЙЛА</b></p>
  <?php endif; ?>
</div>
<?php admin_footer(); ?>
PHP
