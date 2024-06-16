<?php

namespace App\Models;

use App\Models\Level;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model{

    use HasFactory;

    protected $fillable = [
        'question',
        'optionOne',
        'optionTwo',
        'optionThree',
        'rightAnswer',
        'category_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function category(){
        return $this->belongsTo(Level::class);
    }
}
