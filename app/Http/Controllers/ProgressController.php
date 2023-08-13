<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Progress;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgressController extends Controller
{
    public function startQuiz($slug) {
        $thisQuiz = Quiz::where('slug', $slug)->firstOrFail();
        
        $questions = Question::select(['id', 'question_part1', 'quesImage', 'question_part2', 'option1', 'option2', 'option3', 'option4', 'option5', 'quiz_id', 'deleted_at'])
                                ->where("quiz_id", '=', $thisQuiz->id)->whereNull('deleted_at')
                                ->get();
                     

        $quesCount = $questions->count();
        
        
        return view("students.quiz.stage")->with([
                                                    "slug" => $thisQuiz->slug,
                                                    "quizID" => $thisQuiz->id,
                                                    "questions" => $questions,
                                                    "title" => $thisQuiz->title,
                                                    "totalQues" => $quesCount,
                                                ]);
    }

    public function submitQuiz($slug, Request $request) {
        $user = auth()->user();

        $thisQuiz = Quiz::where('slug', $slug)->firstOrFail();
        
        //$examDepts = $thisQuiz->availableFor;
        
        $alreadyProgressed = Progress::where([
            ['user_id', auth()->user()->id], 
            ['quiz_id', $thisQuiz->id], 
        ])->firstOrFail();
        
        $hisAnswers = $request->studentAnswers;
        
        $questions = Question::where('quiz_id', $thisQuiz->id)->whereNull('deleted_at')->get();
        $questionCount = $questions->count();

        $hisAnswersArray = json_decode($hisAnswers, true);
        $userAnswers = array();

        $score = 0;
        $answered = 0;
        $currentQuestion = 0;
        

        foreach($questions as $question) {
            $thisAnswer = null;
            foreach($hisAnswersArray as $ans) {
                if($question->id == $ans['quesID']) {
                    $thisAnswer = $ans['chosenOption'];
                    
                    if($question->correct_answer == $ans['chosenOption']) {
                        $score++;
                        $answered++;
                    } elseif($ans['chosenOption'] || $ans['chosenOption'] != null ) {
                        $score = $score - 0;
                        $answered++;
                    } 
                }
            }
            
            array_push($userAnswers, $thisAnswer);

        }
        
        DB::insert('insert into student_answers (user_id, progress_id ,quiz_id, answers) values (?, ?, ?, ?)', [$user->id, $alreadyProgressed->id, $thisQuiz->id, $hisAnswers]);

        $alreadyProgressed->attended_ques_count = $answered;
        $alreadyProgressed->submission_status = 1;
        $alreadyProgressed->answered_correctly = $score;
        $alreadyProgressed->actual_end_time = date('Y-m-d H:i:s', time());
        $alreadyProgressed->score = $score * $thisQuiz->max_marks / $questionCount;
        $alreadyProgressed->userAnswer = $userAnswers;
        $alreadyProgressed->save();

        return redirect(route('students.quiz.scorecard', ['slug' => $thisQuiz->slug]));
    }

    public function scoreCard($slug) {
        $quiz = Quiz::where('slug', $slug)->firstOrFail();
        $questions = Question::where('quiz_id', $quiz->id)->whereNull('deleted_at')->get();
        $questionCount = $questions->count();

        $user = auth()->user()->id;

        $alreadyProgressed = Progress::where([
            ['user_id', $user], 
            ['quiz_id', $quiz->id], 
        ])->first();

        $userAnswers = $alreadyProgressed->userAnswer;
        $score = $alreadyProgressed->score;

        return view("students.quiz.scorecard")->with([
            'title' => $quiz->title,
            'questions' => $questions,
            'questionCount' => $questionCount,
            'score' => $score,
            'answered' => $alreadyProgressed->answered_correctly,
            'score' => $score,
            'maxMarks' => $quiz->max_marks,
            'answers' => $userAnswers
        ]);
    }

    public function changeStudentAttempt($pid, $sid, Request $request) {
        $thisProgress = Progress::findOrFail($pid);
        
        $thisProgress->update([
            'attempts_remain' => $request['newprogress']
        ]);
        
        return redirect()->back()->with(["success" => "Attempts Updated"]);
    }
}
