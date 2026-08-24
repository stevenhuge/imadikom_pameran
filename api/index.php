<?php
// === SCRIPT DIAGNOSIS VERCEL ===
// Jika halaman ini muncul, berarti Vercel PHP berfungsi dan routing tidak loop.

$dbHost = getenv('DB_HOST');
$dbPort = getenv('DB_PORT');

echo "<h1>Vercel PHP Diagnostic</h1>";
echo "<b>PHP Version:</b> " . phpversion() . "<br><br>";

echo "<b>Database Environment Variables:</b><br>";
echo "DB_HOST: " . ($dbHost ? $dbHost : "<span style='color:red'>KOSONG / TIDAK TERBACA</span>") . "<br>";
echo "DB_PORT: " . ($dbPort ? $dbPort : "<span style='color:red'>KOSONG</span>") . "<br><br>";

if (!$dbHost || $dbHost === '127.0.0.1') {
    echo "<h2 style='color:red'>ERROR: Vercel gagal membaca Environment Variable DB_HOST Anda!</h2>";
    echo "<p>Karena DB_HOST kosong, Laravel mencoba koneksi ke 127.0.0.1 dan inilah yang menyebabkan website 'loading terus' (504 Timeout).</p>";
    exit;
}

echo "<i>Mencoba koneksi ke Database ($dbHost:$dbPort)...</i><br>";
try {
    $pdo = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=" . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), [PDO::ATTR_TIMEOUT => 3]);
    echo "<h2 style='color:green'>KONEKSI DATABASE BERHASIL!</h2>";
} catch (PDOException $e) {
    echo "<h2 style='color:red'>KONEKSI DATABASE GAGAL!</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}

echo "<hr><p>Hapus file <code>api/index.php</code> ini dan kembalikan ke <code>require __DIR__ . '/../public/index.php';</code> jika sudah selesai diperbaiki.</p>";
exit;