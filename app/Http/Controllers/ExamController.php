<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\QnaExam;
use App\Models\UserAnswer;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function loadExamDashboard($id){
        $exam = Exam::where('entrance_id',$id)->with('getQnaExam')->get();
        if(count($exam) > 0){

            $attemptCount = ExamAttempt::where('exam_id',$exam[0]->id)->where('user_id',Auth::user()->id)->count();
            if($attemptCount>=$exam[0]->no_of_attempts_possible){
                return view('exam-dashboard',['status'=>false,'msg'=>'You have reached your maximum attempt count','exam'=>$exam]);
            }
        
            else if($exam[0]->date == date('Y-m-d')){
                if(count($exam[0]->getQnaExam) > 0){
                    $qna = QnaExam::where('exam_id',$exam[0]->id)->with('questions')->inRandomOrder()->get();
                    return view('exam-dashboard',['status'=>true,'exam'=>$exam,'qna'=>$qna]);
                }
                else{
                    return view('exam-dashboard',['status'=>false,'msg'=>'This exam is not available for now','exam'=>$exam]);
                }
            }
            else if($exam[0]->date > date('Y-m-d')){
                return view('exam-dashboard',['status'=>false,'msg'=>'This exam will start on ' . $exam[0]->date,'exam'=>$exam]);
            }
            else{
                return view('exam-dashboard',['status'=>false,'msg'=>'This exam expired on ' . $exam[0]->date,'exam'=>$exam]);
            }



        }
        else{
            return view('404');
        }
    }


    public function examSubmit(Request $request){
        
        $attempt_id = ExamAttempt::insertGetId([
            'exam_id' => $request->exam_id,
            'user_id' => Auth::user()->id,
        ]);

        $qcount = count($request->q);
        if($qcount>0){

            for($i=0;$i<$qcount;$i++){
                if(!empty($request->input('ans_'.$i+1))){
                    UserAnswer::insert([
                        'attempt_id' => $attempt_id,
                        'question_id' => $request->q[$i],
                        'answer_id' => $request->input('ans_'.$i+1),
                    ]);
                }
                
            }          
        }

        return view('thank-you');


    }






}
