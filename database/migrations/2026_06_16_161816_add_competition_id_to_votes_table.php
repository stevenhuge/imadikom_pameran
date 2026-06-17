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
        Schema::table('votes', function (Blueprint $table) {
            $table->foreignId('competition_id')->nullable()->constrained()->onDelete('cascade');
            
            // Drop foreign key before dropping index
            $table->dropForeign(['user_id']);
            // Drop old unique index and create new one
            $table->dropUnique(['user_id']);
            $table->unique(['user_id', 'competition_id']);
            // Restore foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'competition_id']);
            $table->unique('user_id');
            $table->dropForeign(['competition_id']);
            $table->dropColumn('competition_id');
        });
    }
};
