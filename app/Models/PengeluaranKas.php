<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class PengeluaranKas extends TransaksiKas
{
    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope('keluar', function (Builder $builder) {
            $builder->where('jenis_transaksi', 'Keluar');
        });
    }
}
