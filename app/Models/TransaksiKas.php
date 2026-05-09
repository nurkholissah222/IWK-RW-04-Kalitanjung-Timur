<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\RtIsolationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

use Illuminate\Database\Eloquent\Builder;

#[ScopedBy([RtIsolationScope::class])]
class TransaksiKas extends Model
{
    protected $table = 'transaksi_kas';
    
    protected $fillable = [
        'rt_id',
        'kategori_id',
        'warga_id',
        'jenis_transaksi',
        'jenis_iuran',
        'jumlah',
        'tanggal',
        'uraian',
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
    
    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2'
    ];

    public function rtUnit() {
        return $this->belongsTo(RtUnit::class, 'rt_id');
    }
    public function category() {
        return $this->belongsTo(Category::class, 'kategori_id');
    }
    public function warga() {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    /**
     * Logic Scope: Memfilter transaksi berdasarkan wilayah RT.
     */
    public function scopeByRt(Builder $query, ?int $rtId): Builder
    {
        if ($rtId) {
            return $query->where('rt_id', $rtId);
        }
        return $query;
    }
}
