<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'type',
        'name',
        'description',
    ];

    public function transaksiKas() {
        return $this->hasMany(TransaksiKas::class, 'kategori_id');
    }
}
