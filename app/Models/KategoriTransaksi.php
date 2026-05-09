<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriTransaksi extends Model
{
    protected $table = 'kategori_transaksi';

    protected $fillable = [
        'nama_kategori',
        'tipe',
        'nominal_default',
        'uraian_default',
    ];

    public function transaksiKas()
    {
        return $this->hasMany(TransaksiKas::class, 'kategori_id');
    }
}
