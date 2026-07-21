<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Support\Str;

class Poster extends Model
{
    use HasUuids;

    protected $fillable = ['judul', 'slug', 'deskripsi', 'konten', 'gambar', 'kategori', 'aktif'];
    protected $casts = ['aktif' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function ($poster) {
            if (empty($poster->slug)) {
                $poster->slug = Str::slug($poster->judul) . '-' . time();
            }
        });
    }
}
