<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'skill_id', 'category', 'level', 'description', 'image', 'youtube_url'
    ];
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
