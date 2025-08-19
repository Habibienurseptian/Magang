<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningStatus extends Model
{
    protected $fillable = ['user_id', 'learning_id', 'status'];
}
