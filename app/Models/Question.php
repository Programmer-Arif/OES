<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question',
        'explaination',
    ];

    public function answers(){
        return $this->hasMany(Answer::class);
    }
}
