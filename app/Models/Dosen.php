<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Dosen extends Model
{
    use HasUuids;

    protected $fillable = [
        'nama', 'jabatan', 'foto', 'urutan', 'aktif',
        'program_studi', 'jabatan_akademik', 'status_pegawai', 'nidn',
        'nuptk', 'google_scholar_link', 'email', 'pendidikan_terakhir'
    ];
    protected $casts = ['aktif' => 'boolean'];
}