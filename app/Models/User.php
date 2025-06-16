<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'user_id';

    protected $table = 'users';

    protected $casts = [
        'is_deleted' => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'nama_pengguna',
        'email',
        'password',
        'foto_profil',
        'peran_id',
        'is_deleted',
    ];

    protected $hidden = [
        'password',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->user_id)) {
                $user->user_id = (string) Str::uuid();
            }
        });
    }

    public function log_aksi()
    {
        return $this->hasMany(LogAksi::class, 'user_id', 'user_id');
    }

    public function peran()
    {
        return $this->belongsTo(Peran::class, 'peran_id', 'peran_id');
    }
}
