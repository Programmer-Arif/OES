<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    protected $fillable = [
        'exam_id',
        'user_id',
    ];

    public function exam(){
        return $this->belongsTo(Exam::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
