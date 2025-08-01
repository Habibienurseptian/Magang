<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'skill_id',
        'level',
        'duration',
        'description',
        'is_available',
    ];
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
    public function soals()
    {
        return $this->hasMany(Soal::class, 'competency_id');
    }
}
