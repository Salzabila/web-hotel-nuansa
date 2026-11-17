<?php

// Pastikan direktori writeable di /tmp tersedia untuk Laravel di lingkungan serverless Vercel
$dirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/logs'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Handler SQLite untuk Serverless (jika tidak menggunakan database MySQL luar)
if (getenv('DB_CONNECTION') === 'sqlite' || !getenv('DB_CONNECTION')) {
    $sourceSqlite = __DIR__ . '/../database/database.sqlite';
    $targetSqlite = '/tmp/database.sqlite';
    if (!file_exists($targetSqlite) && file_exists($sourceSqlite)) {
        @copy($sourceSqlite, $targetSqlite);
    }
    if (file_exists($targetSqlite)) {
        putenv('DB_DATABASE=' . $targetSqlite);
        $_ENV['DB_DATABASE'] = $targetSqlite;
        $_SERVER['DB_DATABASE'] = $targetSqlite;
    }
}

// Arahkan ke front controller utama Laravel
require __DIR__ . '/../public/index.php';
