<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'level_id',
        'current_question_index',
        'is_level_completed',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
