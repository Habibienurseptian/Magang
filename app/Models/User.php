<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nik',
        'name',
        'email',
        'phone',
        'password',
        'role',
        'skill',
        'skill_level',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke riwayat uji kompetensi user
    public function competencyHistories()
    {
        return $this->hasMany(UserCompetencyHistory::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'learning_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }
    
}
