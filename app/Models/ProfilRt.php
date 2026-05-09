<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilRt extends Model
{
    protected $fillable = [
        'rt_id',
        'foto',
        'nama_bendahara',
        'no_wa_bendahara',
        'nama_rt',
        'no_wa_rt',
    ];
}
