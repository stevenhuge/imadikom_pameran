<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('poster_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // KUNCI UTAMA: Satu user hanya bisa vote SATU poster saja (paling umum)
            // Ganti ke unique(['user_id','poster_id']) jika ingin 1 vote per poster
            $table->unique('user_id'); // 1 vote total per user
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};