<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'admin', 'voter', 'participant') NOT NULL DEFAULT 'voter'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert safely by keeping participant as voter or simply resetting enum
        // DB::statement("UPDATE users SET role = 'voter' WHERE role = 'participant'");
        // DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'admin', 'voter') NOT NULL DEFAULT 'voter'");
    }
};
