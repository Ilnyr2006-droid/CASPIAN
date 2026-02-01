<?php
declare(strict_types=1);

function admin_header(string $title, string $active): void {
  $items = [
    'dashboard' => ['name' => 'Дашборд', 'href' => '/admin/dashboard.php'],
    'products'  => ['name' => 'Товары',  'href' => '/admin/products.php'],
    'news'      => ['name' => 'Новости', 'href' => '/admin/news.php'],
    'projects'  => ['name' => 'Проекты', 'href' => '/admin/projects.php'],
    'media'     => ['name' => 'Медиа',   'href' => '/admin/media.php'],
  ];
  ?>
  <!doctype html>
  <html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
      body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial;}
      .layout{display:flex;min-height:100vh;background:#0b1220;color:#e8eefc}
      .side{width:240px;padding:18px;border-right:1px solid rgba(255,255,255,.08)}
      .brand{font-weight:800;letter-spacing:.4px;margin-bottom:14px}
      .nav a{display:block;padding:10px 12px;border-radius:10px;color:#e8eefc;text-decoration:none;margin:6px 0;background:rgba(255,255,255,.03)}
      .nav a.active{background:rgba(90,166,255,.20);outline:1px solid rgba(90,166,255,.25)}
      .content{flex:1;padding:22px;background:linear-gradient(180deg,#0b1220,#070b14)}
      .top{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}
      .card{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:14px;padding:14px}
      textarea{width:100%;min-height:520px;border-radius:12px;border:1px solid rgba(255,255,255,.12);background:rgba(0,0,0,.25);color:#e8eefc;padding:12px;font-family:ui-monospace,Menlo,Consolas,monospace;font-size:13px}
      input,button{border-radius:10px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.06);color:#e8eefc;padding:10px 12px}
      button{cursor:pointer}
      .msg-ok{padding:10px 12px;border-radius:12px;background:rgba(60,180,90,.18);border:1px solid rgba(60,180,90,.25);margin:10px 0}
      .msg-err{padding:10px 12px;border-radius:12px;background:rgba(220,60,60,.18);border:1px solid rgba(220,60,60,.25);margin:10px 0}
      .muted{opacity:.75}
      .grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
      a.link{color:#8ec5ff}
      .files{display:flex;flex-wrap:wrap;gap:8px}
      .chip{padding:6px 10px;border-radius:999px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.10);font-size:12px}
    </style>
  </head>
  <body>
  <div class="layout">
    <aside class="side">
      <div class="brand">CASPIAN • Admin</div>
      <nav class="nav">
        <?php foreach ($items as $key => $it): ?>
          <a class="<?= $active===$key?'active':'' ?>" href="<?= $it['href'] ?>"><?= htmlspecialchars($it['name']) ?></a>
        <?php endforeach; ?>
        <a href="/admin/logout.php">Выход</a>
      </nav>
      <div class="muted" style="margin-top:14px;font-size:12px;">
        Данные: /data/*.json<br>Файлы: /uploads/
      </div>
    </aside>
    <main class="content">
      <div class="top">
        <h2 style="margin:0;"><?= htmlspecialchars($title) ?></h2>
        <div class="muted"><?= date('Y-m-d H:i') ?></div>
      </div>
  <?php
}

function admin_footer(): void {
  echo "</main></div></body></html>";
}
PHP
