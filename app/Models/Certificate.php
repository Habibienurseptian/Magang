<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'competency_id', // gunakan nama kolom sesuai konvensi Laravel
        'certificate_url',
        'completed_at',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Competency (uji kompetensi)
    public function competency()
    {
        return $this->belongsTo(Competency::class, 'competency_id');
    }
}
