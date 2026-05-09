<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class PemasukanKas extends TransaksiKas
{
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope('masuk', function (Builder $builder) {
            $builder->where('jenis_transaksi', 'Masuk');
        });
    }
}
