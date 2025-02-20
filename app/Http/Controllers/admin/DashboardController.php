<?php

namespace App\Http\Controllers\admin;

use App\Models\Exam;
use App\Models\User;
use App\Models\Answer;
use App\Models\QnaExam;
use App\Models\Subject;
use App\Models\Question;
use App\Imports\QnaImport;
use App\Exports\ExportStudent;
use App\Models\UserAnswer;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;



class DashboardController extends Controller
{
    public function index() {
        return view('admin.dashboard');
    }

    public function addSubject(Request $request) {
        $validateUser = Validator::make(
            $request->all(),
            [
                'subjectName' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }

        $subject = Subject::insert([
            'subjectName' => $request->subjectName,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Subject Added Successifully',
            'data' => $subject,
        ],200); 
    }

    public function listSubjects() {
        $subjects = Subject::all();
        return response()->json([
            'status' => true,
            'message' => 'Fetched all subject',
            'data' => $subjects,
        ],200); 
    }

    public function updateSubject(Request $request) {
        $validateUser = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'subjectName' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }

        $subject = Subject::find($request->id)->update([
            'subjectName' => $request->subjectName,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Subject Updated Successifully',
            'data' => $subject,
        ],200); 
    }


    public function deleteSubject(Request $request) {
        $validateUser = Validator::make(
            $request->all(),
            [
                'id' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }

        $subject = Subject::find($request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Subject Deleted Successifully',
            'data' => $subject,
        ],200); 
    }


    // Return exams view
    public function viewExams() {
        $subjects = Subject::all();
        return view('admin.view-exam',compact('subjects'));
    }
    public function addExam(Request $request) {
        $validateUser = Validator::make(
            $request->all(),
            [
                'examName' => 'required',
                'subjectSelect' => 'required',
                'examDate' => 'required',
                'examTime' => 'required',
                'examAttempt' => 'required',
                'plan' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }

        $unique_id = uniqid('exid');

        $plan = $request->plan;
        $prices = null;
        if(isset($request->inr) && isset($request->usd)){
            $prices = json_encode(['INR'=>$request->inr, 'USD'=>$request->usd]);
        }


        $exam = Exam::insert([
            'examName' => $request->examName,
            'subject_id' => $request->subjectSelect,
            'date' => $request->examDate,
            'time' => $request->examTime,
            'no_of_attempts_possible' => $request->examAttempt,
            'entrance_id' => $unique_id,
            'plan' => $plan,
            'prices' => $prices,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Exam Added Successifully',
            'data' => $exam,
        ],200); 
    }
    public function listExams() {
        $exams = Exam::with('subject')->get();
        return response()->json([
            'status' => true,
            'message' => 'Fetched all exams',
            'data' => $exams,
        ],200); 
       
    }
    public function updateExamModal(Request $request) {

        $exam = Exam::where('id',$request->id)->get()->first();

        return response()->json([
            'status' => true,
            'message' => 'Exam Model Populated Successifully',
            'data' => $exam,
        ],200); 
       
    }
    public function updateExam(Request $request) {
        $validateUser = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'examName' => 'required',
                'subjectSelect' => 'required',
                'examDate' => 'required',
                'examTime' => 'required',
                'examAttempt' => 'required',
                'plan' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }


        $plan = $request->plan;
        $prices = null;
        if(isset($request->inr) && isset($request->usd)){
            $prices = json_encode(['INR'=>$request->inr, 'USD'=>$request->usd]);
        }


        $exam = Exam::find($request->id)->update([
            'examName' => $request->examName,
            'subject_id' => $request->subjectSelect,
            'date' => $request->examDate,
            'time' => $request->examTime,
            'no_of_attempts_possible' => $request->examAttempt,
            'plan' => $plan,
            'prices' => $prices,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Exam Updated Successifully',
            'data' => $exam,
        ],200); 
    }
    public function deleteExam(Request $request) {
        $validateUser = Validator::make(
            $request->all(),
            [
                'id' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }

        $exam = Exam::find($request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Exam Deleted Successifully',
            'data' => $exam,
        ],200); 
    }




    // Return exams view
    public function viewQNA() {
        return view('admin.view-qna');
    }
    public function addQNA(Request $request) {
    
        $validateUser = Validator::make(
            $request->all(),
            [
                'question' => 'required',
                'answers' => 'required|array|min:2|max:6',
                'answers.*' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }



        $explaination = null;
        if(isset($request->explaination)){
            $explaination = $request->explaination;
        }

        $escaped_question = htmlspecialchars($request->question,ENT_QUOTES);
        $questionId = Question::insertGetId([
            'question' => $escaped_question,
            'explaination' => $explaination,
        ]);
        
        foreach($request->answers as $answer){
            $is_correct = false;
            if($request->is_correct == $answer){
                $is_correct = true;
            }

            $escaped_answer = htmlspecialchars( $answer,ENT_QUOTES);
            Answer::insert([
                'question_id' => $questionId,
                'answer' => $escaped_answer,
                'is_correct' => $is_correct,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Q&A Added Successifully',
        ],200); 
    }



    public function importQNA(Request $request){
        $validateUser = Validator::make(
            $request->all(),
            [
                'import_qna' => 'required|file',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }

        Excel::import(new QnaImport,$request->file('import_qna'));

        return response()->json([
            'status' => true,
            'message' => 'Q&A Imported Successifully',
        ],200); 
    }

    public function listQNA() {
        $qna = Question::get();
        return response()->json([
            'status' => true,
            'message' => 'Fetched all Q&A',
            'data' => $qna,
        ],200); 
       
    }


    public function showAnsModal(Request $request) {
        $ans = Answer::where('question_id',$request->id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Fetched all answers',
            'data' => $ans,
        ],200); 
       
    }
    public function updateQNAModal(Request $request) {

        $qna = Question::where('id',$request->id)->with('answers')->first();

        return response()->json([
            'status' => true,
            'message' => 'Q&A Model Populated Successifully',
            'data' => $qna,
        ],200); 
       
    }


    public function removeAns(Request $request) {

        Answer::where('id',$request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Removed answer Successifully',
        ],200); 
       
    }
    public function updateQNA(Request $request) {
        // return response()->json($request->all());
        $validateUser = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'question' => 'required',
                // 'answers' => 'required|array|min:2|max:6',
                // 'answers.*' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }



        $explaination = null;
        if(isset($request->explaination_updt)){
            $explaination = $request->explaination_updt;
        }

        Question::where('id',$request->id)->update([
            'question' => $request->question,
            'explaination' => $explaination,
        ]);


        // Old answer update
        if (isset($request->answers)){
            foreach($request->answers as $key => $answer){
                $is_correct = false;
                if($request->is_correct == $answer){
                    $is_correct = true;
                }
                Answer::where('question_id',$request->id)->where('id',$key)->update([
                    'answer' => $answer,
                    'is_correct' => $is_correct,
                ]);
            }
        }
        // New answer add
        if (isset($request->new_answers)){
            foreach($request->new_answers as $answer){
                $is_correct = false;
                if($request->is_correct == $answer){
                    $is_correct = true;
                }
                Answer::insert([
                    'question_id' => $request->id,
                    'answer' => $answer,
                    'is_correct' => $is_correct,
                ]);
            }
        }
        
        
        
        return response()->json([
            'status' => true,
            'message' => 'Q&A Updated Successifully',
        ],200); 
    }


    public function deleteQNA(Request $request) {
        $validateUser = Validator::make(
            $request->all(),
            [
                'id' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }

        Question::find($request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Q&A Deleted Successifully',
        ],200); 
    }


    public function viewStudents() {
        return view('admin.view-students');
    }

    public function listStudents() {
        $students = User::get();
        return response()->json([
            'status' => true,
            'message' => 'Fetched all Students',
            'data' => $students,
        ],200); 
       
    }
    public function exportStudents() {
        return Excel::download(new ExportStudent,'students.xlsx');
       
    }

    public function getQuestions(Request $request) {
        $validateUser = Validator::make(
            $request->all(),
            [
                'exam_id' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }

        
        $questions = Question::all();

        $data = [];
        $counter = 0;
        foreach($questions as $question){
            $qnaExam = QnaExam::where('exam_id',$request->exam_id)->where('question_id',$question->id)->get();
            if(count($qnaExam)==0){
                $data[$counter]['id'] =  $question->id;
                $data[$counter]['question'] =  $question->question;
                $counter++;
            }
        }
        

        return response()->json([
            'status' => true,
            'message' => 'Fetched all Questions',
            'data' => $data,

        ],200); 
       
    }
    public function addQuestions(Request $request) {
        $validateUser = Validator::make(
            $request->all(),
            [
                'exam_id' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }


        if(isset($request->question_ids)){
            foreach($request->question_ids as $qid){
                QnaExam::insert([
                    'exam_id' => $request->exam_id,
                    'question_id' => $qid,
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'Questions added successifully',
            ],200); 
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'No questions are added',
            ],200);
        }
        
       
    }

    public function showQuestions(Request $request){
        $validateUser = Validator::make(
            $request->all(),
            [
                'show_exam_id' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }

        
        $questions = QnaExam::where('exam_id',$request->show_exam_id)->with('questions')->get();
        

        return response()->json([
            'status' => true,
            'message' => 'Fetched all Questions',
            'data' => $questions,
        ],200); 
    }


    public function deleteQuestion(Request $request){
        $validateUser = Validator::make(
            $request->all(),
            [
                'id' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }

        QnaExam::find($request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Question Deleted Successifully',
        ],200); 
    }


    public function viewMarks() {
        return view('admin.view-marks');
    }

    public function listMarks() {
        $exams = Exam::with('getQnaExam')->get();
        
        return response()->json([
            'status' => true,
            'message' => 'Fetched all Exams',
            'data' => $exams,
        ],200); 
    }

    public function updateMarksModal(Request $request) {
        $exam = Exam::where('id',$request->id)->with('getQnaExam')->get()->first();
        return response()->json([
            'status' => true,
            'message' => 'Fetched all Exams',
            'data' => $exam,
        ],200); 
    }

    public function updateMarks(Request $request) {
       
        $validateUser = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'marks_per_q' => 'required',
                'Pmarks' => 'required',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data'=> $validateUser->errors()->all(),
            ],200); 
        }

        $exam = Exam::find($request->id)->update([
            'marks_per_q' => $request->marks_per_q,
            'passing_marks' => $request->Pmarks,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Exam Updated Successifully',
            'data' => $exam,
        ],200); 
    }


    public function viewReview(){
        return view('admin.view-review');
    }

    public function listExamReview(){
        $examsAttempt = ExamAttempt::with('exam','user','exam.subject')->orderBy('id','desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Fetched all Exams',
            'data' => $examsAttempt,
        ],200); 
    }
    public function reviewQNA(Request $request){
        try{
            $attemptData = UserAnswer::where('attempt_id',$request->attempt_id)->with('question','answers')->get();
            return response()->json([
                'status' => true,
                'message' => 'Fetched attempt data',
                'data' => $attemptData,
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ],200);
        }

    }

    public function approvedQNA(Request $request){
        try{
            $attempt_id = $request->attempt_id;
            $examData = ExamAttempt::where('id',$attempt_id)->with('user','exam')->get();
            $marks_per_q = $examData[0]->exam->marks_per_q;

            $attemptData = UserAnswer::where('attempt_id',$attempt_id)->with('answers')->get();
            $totalMarks=0;
            

            if(count($attemptData) > 0){
                foreach($attemptData as $attempt){
                    if($attempt->answers->is_correct == 1){
                        $totalMarks += $marks_per_q;
                    }
                }
            }

            ExamAttempt::where('id',$attempt_id)->update([
                'status' => true,
                'marks' => $totalMarks
            ]);



            $url = URL::to('/');
            $data['url'] = $url.'/results';
            $data['name'] = $examData[0]->user->name;
            $data['email'] = $examData[0]->user->email;
            $data['exam_name'] = $examData[0]->exam->examName;
            $data['title'] = $examData[0]->exam->examName.' Result';

            Mail::send('admin.result-mail',['data' => $data], function($message) use ($data){
                $message->to($data['email'])->subject($data['title']);
            });


            return response()->json([
                'status' => true,
                'message' => 'Approved student successifully',
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ],200);
        }

    }




    
    

}
