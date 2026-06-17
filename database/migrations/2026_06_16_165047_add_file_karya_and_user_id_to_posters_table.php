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
        Schema::table('posters', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('file_karya')->nullable(); // For PDF files
            // Allow gambar to be nullable if they only upload PDF initially, though usually a cover is nice.
            // But we already made gambar nullable in Controller? Wait, let's keep database as is or make it nullable.
            $table->string('gambar')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posters', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'file_karya']);
            $table->string('gambar')->nullable(false)->change();
        });
    }
};
