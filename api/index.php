<?php
/**
 * Vercel PHP Serverless Entry Point
 */

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

try {
    // === VERCEL TRACE DIAGNOSTIC ===
    // Kita akan mencari tahu di baris mana Laravel macet!
    echo "<h1>Vercel Boot Trace</h1>";
    
    echo "[1] Inisialisasi App Laravel...<br>";
    $app = require_once __DIR__.'/../bootstrap/app.php';
    echo "[OK] App Laravel berhasil diinisialisasi.<br>";

    echo "[2] Setup Storage Path ke /tmp...<br>";
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
    echo "[OK] Storage Path berhasil disetup.<br>";

    echo "[3] Fix Routing Vercel...<br>";
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    echo "[OK] Routing berhasil disetup.<br>";

    echo "[4] Menangkap Request...<br>";
    $request = Illuminate\Http\Request::capture();
    echo "[OK] Request berhasil ditangkap.<br>";
    
    echo "[5] Membuat Kernel...<br>";
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "[OK] Kernel berhasil dibuat.<br>";
    
    echo "<h2>JIKA ANDA MELIHAT INI, BERARTI LARAVEL BERHASIL BOOTING 100%!</h2>";
    echo "<p>Masalah macetnya (loading terus) PASTI ada di dalam Controller atau Database saat Request diproses (Kernel->handle).</p>";
    
    // Stop execution here to prove where it hangs!
    exit;

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