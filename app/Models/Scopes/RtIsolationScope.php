<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class RtIsolationScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Bypass filter for Admin RW (Akses Global)
            if ($user->isAdmin()) {
                return;
            }

            // Untuk Petugas RT, paksa filter berdasarkan rt_id mereka.
            $builder->where($model->getTable() . '.rt_id', $user->rt_id);
        }
    }
}
