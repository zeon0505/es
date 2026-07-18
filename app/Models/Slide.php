<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Slide extends Model
{
    use HasUuids;

    protected $fillable = ['judul', 'gambar', 'urutan', 'aktif'];
    protected $casts = ['aktif' => 'boolean'];
}
