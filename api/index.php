<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

// FORCE DEBUG MODE TO SEE THE ERROR ON VERCEL
putenv('APP_DEBUG=true');
$_ENV['APP_DEBUG'] = true;
$_SERVER['APP_DEBUG'] = true;
putenv('APP_ENV=local');
$_ENV['APP_ENV'] = 'local';
$_SERVER['APP_ENV'] = 'local';

try {
    /** @var Application $app */
    $app = require_once __DIR__.'/../bootstrap/app.php';

    $app->useStoragePath('/tmp/storage');

    $directories = [
        '/tmp/storage/framework/views',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/logs',
        '/tmp/storage/app/public',
    ];

    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    $response = $app->handleRequest(Request::capture());
    if (method_exists($response, 'send')) {
        $response->send();
    }
} catch (\Throwable $e) {
    echo "<h1>Vercel Fatal Crash:</h1>";
    echo "<p><b>Message:</b> " . $e->getMessage() . "</p>";
    echo "<p><b>File:</b> " . $e->getFile() . " on line " . $e->getLine() . "</p>";
    echo "<pre style='background:#f4f4f4; padding:10px; overflow-x: auto;'>" . $e->getTraceAsString() . "</pre>";
}
