<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompetencyHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'competency_id', 'score', 'completed_at'
    ];
    protected $casts = [
        'score' => 'string',
        'completed_at' => 'datetime',
    ];
    public function user() { return $this->belongsTo(User::class); }
    public function competency() { return $this->belongsTo(Competency::class); }
}
