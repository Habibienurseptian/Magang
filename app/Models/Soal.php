<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $fillable = [
        'kompetensi_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'answer_key',
    ];

    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }
}
