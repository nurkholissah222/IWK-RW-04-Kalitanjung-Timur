<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\RtIsolationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([RtIsolationScope::class])]
class KartuKeluarga extends Model
{
    protected $fillable = [
        'no_kk',
        'nama_kepala_keluarga',
        'rt_id',
        'last_edited_by',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->last_edited_by = auth()->user()->name;
                // Otomatis isi rt_id jika belum ada (Isolasi Data)
                if (!$model->rt_id && auth()->user()->rt_id) {
                    $model->rt_id = auth()->user()->rt_id;
                }
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->last_edited_by = auth()->user()->name;
            }
        });
    }

    public function rtUnit() {
        return $this->belongsTo(RtUnit::class, 'rt_id');
    }
    public function wargas() {
        return $this->hasMany(Warga::class, 'kk_id');
    }
}
