<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'name',
        'image'

    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function questions() {
        return $this->hasMany(Question::class);
    }
}
