<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Progress;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\SectionProgress;
use Illuminate\Support\Facades\DB;

class ProgressController extends Controller
{
    public function startQuiz($slug) {
        $thisQuiz = Quiz::where('slug', $slug)->firstOrFail();
        
        if($thisQuiz->sections()->count() > 0) {
            $thisSection = $thisQuiz->sections()->first();
            $lastSection = $thisQuiz->sections()->orderBy('id', 'desc')->first();
            $allSections = $thisQuiz->sections;

            //Check if already exam is completed
            $alreadyProgressed = Progress::where([
                ['user_id', auth()->user()->id], 
                ['quiz_id', $thisQuiz->id], 
            ])->firstOrFail();

            $sectionProgress = SectionProgress::create([
                'progress_id' => $alreadyProgressed->id,
                'quiz_section_id' => $thisSection->id,
                'score' => 0,
                'exam_date' => date('Y-m-d', time()),
                'start_time' => date('Y-m-d H:i:s', time()),
                'scheduled_end_time' => date('Y-m-d H:i:s', time()+($thisSection->max_mins*60)),
            ]);

            $questions = Question::select(
                    ['id', 'quiz_section_id', 'question_part1', 'quesImage', 'question_part2', 'option1', 'option2', 'option3', 'option4', 'option5', 'quiz_id', 'deleted_at'])
                    ->where([
                                ["quiz_id", '=', $thisQuiz->id],
                                ["quiz_section_id", '=', $thisQuiz->sections()->first()->id],
                            ])->whereNull('deleted_at')->get();
                        
            $quesCount = $questions->count();
            
            return view("students.quiz.stage")->with([
                "slug" => $thisQuiz->slug,
                "quizID" => $thisQuiz->id,
                "questions" => $questions,
                "thisSection" => $thisSection,
                "thisSectionID" => 1,
                "lastSection" => $lastSection,
                "allSections" => $allSections,
                "title" => $thisQuiz->title,
                "totalQues" => $quesCount,
            ]);
        } else {
        
            $questions = Question::select(['id', 'question_part1', 'quesImage', 'question_part2', 'option1', 'option2', 'option3', 'option4', 'option5', 'quiz_id', 'deleted_at'])
                                    ->where("quiz_id", '=', $thisQuiz->id)->whereNull('deleted_at')
                                    ->get();
                        

            $quesCount = $questions->count();

            return view("students.quiz.arena")->with([
                "slug" => $thisQuiz->slug,
                "quizID" => $thisQuiz->id,
                "questions" => $questions,
                "title" => $thisQuiz->title,
                "totalQues" => $quesCount,
            ]);
        }
        
        
        
    }

    public function submitQuiz($slug, Request $request) {
        $user = auth()->user();

        $thisQuiz = Quiz::where('slug', $slug)->firstOrFail();
        $quizSectionsCount = $thisQuiz->sections()->count();
        
        //Check if already exam is completed
        $alreadyProgressed = Progress::where([
            ['user_id', auth()->user()->id], 
            ['quiz_id', $thisQuiz->id], 
        ])->firstOrFail();
        
        //Get student answers in JSON
        $hisAnswers = $request->studentAnswers;

        //Get all exam questions and its count
        $questions = Question::where('quiz_id', $thisQuiz->id)->whereNull('deleted_at')->get();
        $questionCount = $questions->count();

        //Initialize counter variables
        $score = 0;
        $answered = 0;
        $currentQuestion = 0;

        //Convert student answers to Array
        $hisAnswersArray = json_decode($hisAnswers, true);
        $userAnswers = array();

        //Loop through all the questions
        foreach($questions as $question) {
            $thisAnswer = null;
            
            //Loop through all the answers
            foreach($hisAnswersArray as $ans) {
                
                //If question ID matches in the answer array and the list of questions
                if($question->id == $ans['quesID']) {
                    //Get individual question's answer from the student answer array
                    $thisAnswer = $ans['chosenOption'];
                    
                    //Compare it with the actual answer
                    if($question->correct_answer == $ans['chosenOption']) {
                        //If answer is right, add one to the score and to the answered questions counter
                        $score++;
                        $answered++;
                    } elseif($ans['chosenOption'] || $ans['chosenOption'] != null ) {
                        //If answer is incorrect, add any negative marks if applicable
                        //Then simply add one to the answered questions counter
                        $score = $score - 0;
                        $answered++;
                    } 
                }
            }
            
            //Push all student answers into the final array that has to be stored in DB
            array_push($userAnswers, $thisAnswer);

        }
        
        DB::insert('insert into student_answers (user_id, progress_id ,quiz_id, answers) values (?, ?, ?, ?)', [$user->id, $alreadyProgressed->id, $thisQuiz->id, $hisAnswers]);

        $alreadyProgressed->attended_ques_count = $answered;
        $alreadyProgressed->answered_correctly = $score;
        $alreadyProgressed->actual_end_time = date('Y-m-d H:i:s', time());
        $alreadyProgressed->score = $score * $thisQuiz->max_marks / $questionCount;
        $alreadyProgressed->userAnswer = $userAnswers;
        $alreadyProgressed->submission_status = 1;
        $alreadyProgressed->save();
        return redirect(route('students.quiz.scorecard', ['slug' => $thisQuiz->slug]));
    }

    public function nextSection($slug, $stage) {
        $user = auth()->user();
        $thisQuiz = Quiz::where('slug', $slug)->firstOrFail();
        $thisSection = $thisQuiz->sections()->skip($stage-1)->take(1)->get()->first();
        $lastSection = $thisQuiz->sections()->orderBy('id', 'desc')->first();
        $allSections = $thisQuiz->sections;

        $questions = Question::select(
                ['id', 'quiz_section_id', 'question_part1', 'quesImage', 'question_part2', 'option1', 'option2', 'option3', 'option4', 'option5', 'quiz_id', 'deleted_at'])
                ->where([
                            ["quiz_id", '=', $thisQuiz->id],
                            ["quiz_section_id", '=', $thisSection->id],
                        ])->whereNull('deleted_at')->get();
                        
        $quesCount = $questions->count();

        //Check if already exam is completed
        $alreadyProgressed = Progress::where([
            ['user_id', auth()->user()->id], 
            ['quiz_id', $thisQuiz->id], 
        ])->firstOrFail();

        $sectionProgress = SectionProgress::create([
            'progress_id' => $alreadyProgressed->id,
            'quiz_section_id' => $thisSection->id,
            'score' => 0,
            'exam_date' => date('Y-m-d', time()),
            'start_time' => date('Y-m-d H:i:s', time()),
            'scheduled_end_time' => date('Y-m-d H:i:s', time()+($thisSection->max_mins*60)),
        ]);
            
        return view("students.quiz.stage")->with([
            "slug" => $thisQuiz->slug,
            "quizID" => $thisQuiz->id,
            "questions" => $questions,
            "thisSection" => $thisSection,
            "lastSection" => $lastSection,
            "allSections" => $allSections,
            "thisSectionID" => $stage,
            "title" => $thisQuiz->title,
            "totalQues" => $quesCount,
        ]);
    }

    public function submitSection($slug, $stage, Request $request) {
        $user = auth()->user();
        $thisQuiz = Quiz::where('slug', $slug)->firstOrFail();
        $quizSectionsCount = $thisQuiz->sections()->count();
        
        $thisSection = $thisQuiz->sections()->skip($stage-1)->take(1)->get()->first();
        $lastSection = $thisQuiz->sections()->orderBy('id', 'desc')->first();

        //Check if already exam is completed
        $alreadyProgressed = Progress::where([
            ['user_id', auth()->user()->id], 
            ['quiz_id', $thisQuiz->id], 
        ])->firstOrFail();

        $sectionProgress = $alreadyProgressed->section_progress()->where('quiz_section_id', $thisSection->id)->firstOrFail();
        
        //Get student answers in JSON
        $hisAnswers = $request->studentAnswers;

        //Get all exam questions and its count
        $questions = Question::where([
                        [ 'quiz_id', $thisQuiz->id ], 
                        [ 'quiz_section_id', $thisSection->id]
                    ])->whereNull('deleted_at')->get();
        $questionCount = $questions->count();

        //Initialize counter variables
        $score = 0;
        $answered = 0;
        $currentQuestion = 0;

        //Convert student answers to Array
        $hisAnswersArray = json_decode($hisAnswers, true);
        $userAnswers = array();

        //Loop through all the questions
        foreach($questions as $question) {
            $thisAnswer = null;
            
            //Loop through all the answers
            foreach($hisAnswersArray as $ans) {
                
                //If question ID matches in the answer array and the list of questions
                if($question->id == $ans['quesID']) {
                    //Get individual question's answer from the student answer array
                    $thisAnswer = $ans['chosenOption'];
                    
                    //Compare it with the actual answer
                    if($question->correct_answer == $ans['chosenOption']) {
                        //If answer is right, add one to the score and to the answered questions counter
                        $score++;
                        $answered++;
                    } elseif($ans['chosenOption'] || $ans['chosenOption'] != null ) {
                        //If answer is incorrect, add any negative marks if applicable
                        //Then simply add one to the answered questions counter
                        $score = $score - 0;
                        $answered++;
                    } 
                }
            }
            
            //Push all student answers into the final array that has to be stored in DB
            array_push($userAnswers, $thisAnswer);

        }
        
        $sectionProgress->attended_ques_count = $answered;
        $sectionProgress->answered_correctly = $score;
        $sectionProgress->actual_end_time = date('Y-m-d H:i:s', time());
        $sectionProgress->score = $score * $thisSection->max_marks / $questionCount;
        $sectionProgress->userAnswer = $userAnswers;
        $sectionProgress->save();

        if($thisSection->id == $lastSection->id) {
            $allProgress = $alreadyProgressed->section_progress;
            $totalAnswered = 0;
            $totalCorrect = 0;
            $totalScore = 0;

            foreach($allProgress as $prog) {
                $totalAnswered += $prog->attended_ques_count;
                $totalCorrect += $prog->answered_correctly;
                $totalScore += $prog->score;
            }

            $alreadyProgressed->attended_ques_count = $totalAnswered;
            $alreadyProgressed->answered_correctly = $totalCorrect;
            $alreadyProgressed->actual_end_time = date('Y-m-d H:i:s', time());
            $alreadyProgressed->score = $totalScore;
            $alreadyProgressed->userAnswer = "Find in Sections";
            $alreadyProgressed->submission_status = 1;
            $alreadyProgressed->save();
            return redirect(route('students.quiz.scorecard', ['slug' => $thisQuiz->slug]));
        } else {
            if($quizSectionsCount > 0) {
                return redirect(route('students.quiz.nextstage', ['slug' => $thisQuiz->slug, 'stage' => ((int)$stage + 1)]));
            } 
        }
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
