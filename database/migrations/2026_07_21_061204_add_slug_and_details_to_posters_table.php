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
            $table->string('slug')->nullable()->after('judul');
            $table->text('deskripsi')->nullable()->change();
            $table->longText('konten')->nullable()->after('deskripsi');
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE posters CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    }

    public function down(): void
    {
        Schema::table('posters', function (Blueprint $table) {
            $table->dropColumn(['slug', 'konten']);
        });
    }
};
