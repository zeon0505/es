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
        Schema::table('dosens', function (Blueprint $table) {
            $table->after('jabatan', function ($table) {
                $table->string('program_studi')->nullable();
                $table->string('jabatan_akademik')->nullable();
                $table->string('status_pegawai')->nullable();
                $table->string('nidn')->nullable()->unique();
                $table->string('nuptk')->nullable()->unique();
                $table->string('google_scholar_link')->nullable();
                $table->string('email')->nullable()->unique();
                $table->string('pendidikan_terakhir')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dosens', function (Blueprint $table) {
            $table->dropColumn([
                'program_studi',
                'jabatan_akademik',
                'status_pegawai',
                'nidn',
                'nuptk',
                'google_scholar_link',
                'email',
                'pendidikan_terakhir',
            ]);
        });
    }
};