<?php
/**
 * Vercel PHP Serverless Entry Point
 */

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

try {
    // 1. Inisialisasi App Laravel
    $app = require_once __DIR__.'/../bootstrap/app.php';

    // 2. Set Storage ke /tmp karena /var/task di Vercel itu Read-Only
    $storagePath = '/tmp/storage';
    $app->useStoragePath($storagePath);

    // Buat folder-folder yang dibutuhkan Laravel jika belum ada
    $directories = [
        "$storagePath/framework/views",
        "$storagePath/framework/cache/data",
        "$storagePath/framework/sessions",
        "$storagePath/logs",
        "$storagePath/app/public",
    ];

    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    // 3. Fix Routing Vercel
    $_SERVER['SCRIPT_NAME'] = '/index.php';

    // 4. Proses Request (Ini otomatis memanggil send() di Laravel 11+)
    $app->handleRequest(Illuminate\Http\Request::capture());

} catch (\Throwable $e) {
    // Tangkap error APAPUN agar Vercel tidak timeout (504)
    http_response_code(500);
    echo "<h1>Terjadi Error Fatal di Laravel:</h1>";
    echo "<p><b>Message:</b> " . $e->getMessage() . "</p>";
    echo "<p><b>File:</b> " . $e->getFile() . " on line " . $e->getLine() . "</p>";
    if (getenv('APP_DEBUG') === 'true') {
        echo "<pre style='background:#f4f4f4; padding:10px; overflow-x: auto;'>" . $e->getTraceAsString() . "</pre>";
    }
}