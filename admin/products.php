cat > /var/www/CASPIAN/admin/products.php <<'PHP'
<?php
declare(strict_types=1);
require __DIR__ . '/auth.php';
require_auth();

require __DIR__ . '/lib_storage.php';
require __DIR__ . '/ui.php';

$file = 'products.json';
$msgOk = '';
$msgErr = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    save_json_file($file, (string)($_POST['json'] ?? ''));
    $msgOk = 'Сохранено. Бэкап сделан в /data/.backup/';
  } catch (Throwable $e) {
    $msgErr = $e->getMessage();
  }
}

$raw = read_json_file($file);

admin_header('Товары (products.json)', 'products');
?>
<div class="card">
  <p class="muted">Редактируй данные товаров. JSON должен быть валидным. Перед сохранением создаётся бэкап.</p>
  <?php if ($msgOk): ?><div class="msg-ok"><?= htmlspecialchars($msgOk) ?></div><?php endif; ?>
  <?php if ($msgErr): ?><div class="msg-err"><?= htmlspecialchars($msgErr) ?></div><?php endif; ?>

  <form method="post">
    <textarea name="json"><?= htmlspecialchars($raw, ENT_QUOTES) ?></textarea>
    <div style="display:flex;gap:10px;margin-top:10px;align-items:center;">
      <button type="submit">Сохранить</button>
      <span class="muted">Файл: /data/products.json</span>
    </div>
  </form>
</div>
<?php admin_footer(); ?>
PHP
