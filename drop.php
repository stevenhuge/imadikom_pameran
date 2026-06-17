<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    Illuminate\Support\Facades\Schema::table('votes', function ($table) {
        $table->dropForeign(['competition_id']);
        $table->dropColumn('competition_id');
    });
    echo "Dropped column.";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
