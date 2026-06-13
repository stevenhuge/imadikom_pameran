<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'admin@voting.com')->first();
if ($user) {
    echo "Found user: " . $user->email . " with role: " . $user->role . "\n";
    $user->update(['role' => 'superadmin']);
    echo "Updated role to superadmin.\n";
} else {
    echo "User not found.\n";
    App\Models\User::create([
        'name' => 'Admin Utama',
        'email' => 'admin@voting.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'role' => 'superadmin'
    ]);
    echo "Created user.\n";
}
