<?php
declare(strict_types=1);

function data_dir(): string {
  return realpath(__DIR__ . '/../data') ?: (__DIR__ . '/../data');
}

function uploads_dir(): string {
  return realpath(__DIR__ . '/../uploads') ?: (__DIR__ . '/../uploads');
}

function allowed_data_files(): array {
  return [
    'products.json' => 'Товары',
    'news.json'     => 'Новости',
    'projects.json' => 'Проекты',
  ];
}

function data_path(string $file): string {
  $allowed = allowed_data_files();
  if (!isset($allowed[$file])) {
    http_response_code(400);
    die('Недопустимый файл');
  }
  return rtrim(data_dir(), '/') . '/' . $file;
}

function read_json_file(string $file): string {
  $path = data_path($file);
  if (!file_exists($path)) return "{\n}\n";
  $raw = (string)file_get_contents($path);
  if (trim($raw) === '') return "{\n}\n";
  return $raw;
}

function pretty_json(string $raw): string {
  $decoded = json_decode($raw, true);
  if (json_last_error() !== JSON_ERROR_NONE) {
    throw new RuntimeException('Ошибка JSON: ' . json_last_error_msg());
  }
  return json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
}

function backup_file(string $file): void {
  $path = data_path($file);
  $backupDir = rtrim(data_dir(), '/') . '/.backup';
  if (!is_dir($backupDir)) @mkdir($backupDir, 0775, true);
  if (file_exists($path)) {
    $ts = date('Ymd-His');
    @copy($path, $backupDir . '/' . $file . '.' . $ts . '.bak');
  }
}

function save_json_file(string $file, string $raw): void {
  $path = data_path($file);
  $pretty = pretty_json($raw); // валидируем и форматируем
  backup_file($file);

  $tmp = $path . '.tmp';
  if (file_put_contents($tmp, $pretty, LOCK_EX) === false) {
    throw new RuntimeException('Не удалось записать временный файл (проверь права на /data)');
  }
  if (!@rename($tmp, $path)) {
    @unlink($tmp);
    throw new RuntimeException('Не удалось заменить файл (проверь права на /data)');
  }
}
PHP
