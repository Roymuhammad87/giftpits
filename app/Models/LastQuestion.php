<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastQuestion extends Model
{
    use HasFactory;
    protected $table = 'last_questions';
    protected $fillable = [
        'question_id',
        'user_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
}
