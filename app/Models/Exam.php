<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $appends = [
        'attempt_counter',
    ];

    public $count = 0;
    
    public function getIdAttribute($value){
        if(Auth::check()){
            $attemptCount = ExamAttempt::where('exam_id',$value)->where('user_id',Auth::user()->id)->count();
            $this->count=$attemptCount;
        }
        return $value;
    }
    
    public function getAttemptCounterAttribute(){
        return $this->count;
    }


    protected $fillable = [
        'examName',
        'subject_id',
        'date',
        'time',
        'no_of_attempts_possible',
        'entrance_id',
        'marks_per_q',
        'passing_marks',
        'plan',
        'prices'
    ];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function getQnaExam(){
        return $this->hasMany(QnaExam::class,'exam_id','id');
    }

    public function examAttempt(){
        return $this->hasMany(ExamAttempt::class,'exam_id','id');
    }

    public function getPaidInformation(){
        return $this->hasMany(ExamPayment::class,'exam_id','id');
    }

}
