<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QnaExam extends Model
{
    protected $fillable = [
        'exam_id',
        'question_id',
    ];

    public function questions(){
        return $this->hasMany(Question::class,'id','question_id');
    }

    // public function answers(){
    //     return $this->hasMany(Answer::class,'question_id','question_id');
    // }
}
