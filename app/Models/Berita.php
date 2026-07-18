<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Berita extends Model
{
    use HasUuids;

    protected $fillable = ['kategori_id', 'judul', 'slug', 'konten', 'gambar', 'tanggal', 'aktif'];
    protected $casts = ['aktif' => 'boolean', 'tanggal' => 'date'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul) . '-' . time();
            }
        });
    }
}
