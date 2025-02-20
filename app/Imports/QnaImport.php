<?php

namespace App\Imports;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class QnaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Log::info($row);

        if($row[0] != 'question'){
            $escaped_question = htmlspecialchars($row[0],ENT_QUOTES);
            $questionId = Question::insertGetId([
                'question' => $escaped_question,
            ]);

            for($i=1;$i<count($row)-1;$i++){
                if($row[$i] != NULL){
                    $is_correct = false;
                    if($row[$i] == $row[7]){
                        $is_correct = true;
                    }
                    $escaped_answer = htmlspecialchars($row[$i],ENT_QUOTES);
                    Answer::insert([
                        'question_id' => $questionId,
                        'answer' => $escaped_answer,
                        'is_correct' => $is_correct,
                    ]);
                }
            }
        }

        // return new Question([
            
        // ]);
    }
}
