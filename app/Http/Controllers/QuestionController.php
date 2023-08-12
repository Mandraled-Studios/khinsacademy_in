<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function changeQuestionDB($quizId, $question, $request) {
        $data = $request->validate([
            'question_part1' => 'required|string|max:255',
            'quesImage' => 'nullable|sometimes|image|mimes:jpg,jpeg,png,gif,svg',
            'question_part2' => 'nullable|string|max:255',
            'option1' => 'required|string|max:255',
            'option2' => 'required|string|max:255',
            'option3' => 'required|string|max:255',
            'option4' => 'nullable|string|max:255',
            'option5' => 'nullable|string|max:255',
            'correct_answer' => 'required|numeric|min:1|max:5',
        ]);

        $question->question_part1 = $data['question_part1'];
        $question->question_part2 = $data['question_part2'];
        $question->option1 = $data['option1'];
        $question->option2 = $data['option2'];
        $question->option3 = $data['option3'];
        $question->option4 = $data['option4'];
        $question->option5 = $data['option5'];
        $question->correct_answer = $data['correct_answer'];
        $question->quiz_id = $quizId;

        if(isset($request->shuffle)) {
            $question->shuffle = 1;
        } else {
            $question->shuffle = 0;
        }
        
        if($request->hasFile('quesImage')) {
            $filename = Quiz::findOrFail($quizId)->slug;    
            //Get extension of file
            $extension =  $request->file('quesImage')->getClientOriginalExtension(); 
            //Filename to store in DB
            $filenameToStore = substr($filename,0,14). "-" . random_int(0000, 9999) . "-" . time() . "." . $extension;
            //Upload image to storage
            $imagePath = $request->file('quesImage')->storeAs('public/images/questions/', $filenameToStore);
            $question->quesImage = "/storage/images/questions/" . $filenameToStore;
        } elseif(!isset($question->quesImage)) {
            $question->quesImage = NULL;
        }

        $question->save();
    }
    
    public function index($slug) {
        $quiz = Quiz::where('slug', $slug)->firstOrFail();
        $questions = Question::where('quiz_id', $quiz->id)->whereNull('deleted_at')->get();
        return view('admin.quiz.questions.index')->with(["title" => "Questions List", 
                                                  "quiz" => $quiz,
                                                  "questions" => $questions ]);
    }

    public function create($slug) {
        $quiz = Quiz::where('slug', $slug)->firstOrFail();
        return view('admin.quiz.questions.create')->with(["title" => "Add A Question",
                                                   "quiz" => $quiz]);
    }

    public function store($id, Request $request) {
        $quiz = Quiz::where('id', $id)->firstOrFail();
        $question = new Question;
        $this->changeQuestionDB($quiz->id, $question, $request);
        return redirect(route('admin.questions.index', ['slug' => $quiz->slug]))->with('success', 'Question Added');
    }

    public function edit($slug, $ques) {
        $quiz = Quiz::where('slug', $slug)->firstOrFail();
        $question = Question::findOrFail($ques);
        return view('admin.quiz.questions.edit')->with([
            "title" => "Edit Question",
            "quiz" => $quiz,
            "question" => $question,
        ]);
    }

    public function update($id, $ques, Request $request) {
        $quiz = Quiz::where('id', $id)->firstOrFail();
        $question = Question::where('id', $ques)->firstOrFail();

        if(isset($request->quesImage)) {
            $this->deleteImage($question->quesImage);
        }

        $this->changeQuestionDB($id, $question, $request);

        return redirect(route('admin.questions.index', ['slug' => $quiz->slug]))->with('success', 'Question Updated');
    }

    public function destroy($id, $ques) {
        $question = Question::on('mysql2')->where([['id', $ques],['exam_id', $id]])->firstOrFail();

        $question->delete();
        
        return redirect()->back()->with('danger', 'Exam Deleted');
    }

    public function deleteImage($quesImage) {
        if($quesImage != NULL) {
            if(file_exists(storage_path($quesImage)))
                File::delete(storage_path($quesImage));
        }
    }
}
