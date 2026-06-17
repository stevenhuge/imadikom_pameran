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
        Schema::table('competitions', function (Blueprint $table) {
            $table->tinyInteger('eligibility_type')->default(4)->after('registration_status');
            // 1: Khusus penerima KIP-K Universitas Amikom Yogyakarta
            // 2: Khusus Mahasiswa Universitas Amikom Yogyakarta
            // 3: Khusus penerima KIP-K perguruan tinggi di Indonesia
            // 4: Seluruh perguruan tinggi yang terdaftar di pemerintah
        });

        Schema::table('posters', function (Blueprint $table) {
            $table->string('file_ktm')->nullable()->after('file_karya');
            $table->string('file_kipk')->nullable()->after('file_ktm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            $table->dropColumn('eligibility_type');
        });

        Schema::table('posters', function (Blueprint $table) {
            $table->dropColumn(['file_ktm', 'file_kipk']);
        });
    }
};
