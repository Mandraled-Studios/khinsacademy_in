<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Progress;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function instructions($slug) {
        $quiz = Quiz::where('slug', $slug)->firstOrFail();

        //Has user appeared before?
        $alreadyProgressed = Progress::where([
            ['user_id', auth()->user()->id], 
            ['quiz_id', $quiz->id], 
         ])->first();

         if($alreadyProgressed === null) {
            $attempts = $quiz->attempts;
         } else {
            $attempts = $alreadyProgressed->attempts_remain;
         }

        return view('students.quiz.instructions')->with([
            "quiz" => $quiz,
            "attempts" => $attempts
        ]);
    }

    public function setupQuiz($slug) {
        $thisQuiz = Quiz::where('slug', $slug)->firstOrFail();
        $alreadyProgressed = Progress::where([
            ['user_id', auth()->user()->id], 
            ['quiz_id', $thisQuiz->id], 
         ])->first();

        //if user has not appeared for this exam before                                    
        if($alreadyProgressed === null) {
            $progress = new Progress;
            $progress->quiz_id = $thisQuiz->id;
            $progress->user_id = auth()->user()->id;
            $progress->submission_status = 0;
            $progress->attended_ques_count = 0;
            $progress->answered_correctly = 0;
            $progress->score = 0;
            $progress->exam_date = date('Y-m-d', time());
            $progress->start_time = date('Y-m-d H:i:s', time());
            $progress->scheduled_end_time = date('Y-m-d H:i:s', time()+($thisQuiz->max_mins*60));

            if($thisQuiz->attempts > 0) {
                $progress->attempts_remain = $thisQuiz->attempts-1;
            } else {
                return redirect(route('students.quiz.pdf'));
            }
        } else {
            //if user has already participated in exam
            $progress = $alreadyProgressed;
            //check if user has attempts remaining
            if($alreadyProgressed->attempts_remain > 0) {
                //reset progress for this exam
                $progress->submission_status = 0;
                $progress->attended_ques_count = 0;
                $progress->answered_correctly = 0;
                $progress->score = 0;
                $progress->exam_date = date('Y-m-d', time());
                $progress->start_time = date('Y-m-d H:i:s', time());
                $progress->scheduled_end_time = date('Y-m-d H:i:s', time()+($thisQuiz->max_mins*60));
                $progress->attempts_remain = $alreadyProgressed->attempts_remain-1;
            } else {
                return redirect(route('students.quiz.scorecard', ['slug' => $thisQuiz->slug]));
            }
        }

        $progress->save();

        return redirect(route('students.quiz.start', ['slug' => $thisQuiz->slug]));
    }

    public function questionPDF($slug) {
        $quiz = Quiz::where('slug', $slug)->firstOrFail();

        return view("students.quiz.questionPDF")->with([ "title" => "View Questions of Completed Exam",
                                                        "quizTitle" => $quiz->title,
                                                        "quespdf" => $quiz->quespdf,
                                                        "answerkey" => $quiz->keypdf
                                                     ]);
    }

    public function timer($exam, $user, Request $request)
    {
          $myexam = Exam::where('slug', $exam)->firstOrFail();
          
          $progress = Progress::where([
              ['user_id', '=', $user],
              ['exam_id', '=', $myexam->id]])->firstOrFail();
          
          $fromtime = date('Y-m-d H:i:s');
          $totime = $progress->end_time;
    
          $time1 = strtotime($fromtime);
          $time2 = strtotime($totime);
      
          
          $difference = $time2 - $time1;
           
          if($difference>0){
            echo json_encode(gmdate("H:i:s", $difference)); 
            //echo json_encode($difference);
          }
          else {
            echo json_encode("Time Up");
            //echo json_encode($difference);
          } 

    }
}
