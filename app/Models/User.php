<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rt_id',
        'role',
        'unit_rt',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rtUnit() {
        return $this->belongsTo(RtUnit::class, 'rt_id');
    }

    /**
     * Logic Helper: Memastikan user/bendahara hanya bisa mengakses data RT-nya.
     * Jika rt_id null, diasumsikan sebagai akun setingkat RW (Super Admin).
     */
    public function hasAccessToRt($rtId): bool
    {
        if (is_null($this->rt_id)) {
            return true;
        }
        
        return (int) $this->rt_id === (int) $rtId;
    }

    /**
     * Logic Helper: Cek apakah user adalah admin (RW)
     */
    public function isAdmin(): bool
    {
        $role = strtoupper($this->role ?? '');
        return $role === 'RW' || $role === 'ADMIN';
    }

    /**
     * Logic Helper: Cek apakah user adalah petugas (RT)
     */
    public function isRt(): bool
    {
        $role = strtoupper($this->role ?? '');
        return $role === 'RT' || $role === 'PETUGAS';
    }

    /**
     * Relationship: Link user to their RT/RW Profile to get photos, names, etc.
     */
    public function profilRt()
    {
        return $this->hasOne(ProfilRt::class, 'rt_id', 'rt_id');
    }

    /**
     * Get the user's profile photo path.
     * Menggunakan data dari database jika ada.
     */
    /*
    public function getProfilePhotoPathAttribute()
    {
        $rt_id = $this->rt_id;
        $profil = \App\Models\ProfilRt::where('rt_id', $rt_id)->first();
        return $profil ? $profil->foto : null;
    }
    */
}
