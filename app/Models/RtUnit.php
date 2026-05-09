<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RtUnit extends Model
{
    protected $fillable = [
        'nomor_rt',
        'nama_ketua',
        'nama_bendahara',
    ];

    public function users() {
        return $this->hasMany(User::class, 'rt_id');
    }
    public function kartuKeluargas() {
        return $this->hasMany(KartuKeluarga::class, 'rt_id');
    }
    public function transaksiKas() {
        return $this->hasMany(TransaksiKas::class, 'rt_id');
    }

    public function wargas() {
        return $this->hasManyThrough(
            Warga::class,
            KartuKeluarga::class,
            'rt_id', // Foreign key on KartuKeluarga table
            'kk_id', // Foreign key on Warga table
            'id',    // Local key on RtUnit table
            'id'     // Local key on KartuKeluarga table
        );
    }
}
