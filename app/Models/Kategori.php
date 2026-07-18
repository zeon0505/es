<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kategori extends Model
{
    use HasUuids;

    protected $fillable = ['nama', 'slug'];

    public function beritas()
    {
        return $this->hasMany(Berita::class);
    }
}
