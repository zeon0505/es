<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Poster extends Model
{
    use HasUuids;

    protected $fillable = ['judul', 'deskripsi', 'gambar', 'kategori', 'aktif'];
    protected $casts = ['aktif' => 'boolean'];
}
