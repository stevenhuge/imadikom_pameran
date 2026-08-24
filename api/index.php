<?php
/**
 * Vercel PHP Serverless Entry Point
 */

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

try {
    // FIX SUPABASE DEADLOCK: Laravel 11 menggunakan CACHE_STORE=database secara default.
    // Supabase Pooler tidak mendukung Advisory Locks yang menyebabkan RateLimiter macet (freeze).
    // Kita harus paksa Vercel menggunakan 'array' atau 'file' untuk Cache dan Session.
    putenv('CACHE_STORE=array');
    $_ENV['CACHE_STORE'] = 'array';
    $_SERVER['CACHE_STORE'] = 'array';
    
    putenv('SESSION_DRIVER=cookie');
    $_ENV['SESSION_DRIVER'] = 'cookie';
    $_SERVER['SESSION_DRIVER'] = 'cookie';
    
    // 1. Inisialisasi App
    $app = require_once __DIR__.'/../bootstrap/app.php';

    // 2. Setup Storage Path ke /tmp
    $storagePath = '/tmp/storage';
    $app->useStoragePath($storagePath);
    
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
    
    // 4. Proses Request (Ini otomatis memanggil send() dan terminate() di Laravel 11+)
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