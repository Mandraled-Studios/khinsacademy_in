<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Occasion;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\DepartmentQuiz;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{

    public function changeExamDB($quiz, $request) {
        $data = $request->validate([
            'occasion_id' => 'required',
            'title' => 'required|max:200',
            'slug' => 'required|max:128|unique:quizzes,slug,'.$quiz->id,
            'description' => 'required|min:10',
            'max_marks' => 'required|numeric|min:1',
            'max_mins' => 'required|numeric|min:1',
            'attempts' => 'required|numeric|min:1',
            'shuffle' => 'required',
            'separate_marks' => 'required',
            'quespdf' => 'nullable|sometimes|file|mimes:pdf',
            'keypdf' => 'nullable|sometimes|file|mimes:pdf',
        ]);

        $quiz->occasion_id = $data['occasion_id'];
        $quiz->title = $data['title'];
        $quiz->slug = $data['slug'];
        $quiz->description = $data['description'];
        $quiz->max_marks = $data['max_marks'];
        $quiz->max_mins = $data['max_mins'];
        $quiz->attempts = $data['attempts'];
        $quiz->shuffle = $data['shuffle'];
        $quiz->separate_marks = $data['separate_marks'];
        
        if($request->hasFile('quespdf')) {
            //Get full filename with extension
            $filenameToStore_no_ext = substr($data['slug'], 0, 40)."-doc-" . random_int(1000,9999)."-". time();  
            //Get extension of file
            $extension_thumb =  $request->file('quespdf')->getClientOriginalExtension(); 
            //Filename to store in DB
            $filenameToStore = $filenameToStore_no_ext . "." . $extension_thumb;
            //Upload doc to storage
            $imagePath_thumb = $request->file('quespdf')->storeAs('public/documents/quiz/questions/', $filenameToStore);
            $quiz->quespdf = "/storage/documents/quiz/questions/" . $filenameToStore;
        }
        
        if($request->hasFile('keypdf')) {
            //Get full filename with extension
            $filenameToStore_no_ext = substr($data['slug'], 0, 40)."-doc-" . random_int(1000,9999)."-". time();  
            //Get extension of file
            $extension_thumb =  $request->file('keypdf')->getClientOriginalExtension(); 
            //Filename to store in DB
            $filenameToStore = $filenameToStore_no_ext . "." . $extension_thumb;
            //Upload doc to storage
            $imagePath_thumb = $request->file('keypdf')->storeAs('public/documents/quiz/key/', $filenameToStore);
            $quiz->keypdf = "/storage/documents/quiz/key/" . $filenameToStore;
        }

        if($request->has('save')) {
            $quiz->publish_status = 0;
            $quiz->published_at = null;
        } else if($request->has('publish')) {
            $totalTime = 0;
            $totalMarks = 0;
            if($quiz->sections()->count() > 0) {
                foreach($quiz->sections as $sec) {
                    $totalTime+=(int)$sec->max_mins;
                    $totalMarks+=(int)$sec->max_marks;
                }
                $quiz->max_mins = $totalTime;
                $quiz->max_marks = $totalMarks;
            }
            $quiz->publish_status = 1;
            $quiz->published_at = date("Y-m-d H:i:s", time());
        }

        $quiz->save();
    }

    public function index() {
        $occasions = Occasion::all();
        $quizzes = Quiz::orderBy('quizzes.created_at', 'desc')->get();

        return view('admin.quiz.index')->with(
                                        [  "title" => "All Exams List",
                                            "occasions" => $occasions,
                                            "quizzes" => $quizzes
                                        ]);
    }
    
    public function create() {
        $occasions = Occasion::all();
        return view('admin.quiz.create')->with([
            "title" => "Create A New Quiz",
            "occasions" => $occasions
        ]);
    }
    
    public function store(Request $request) {
        $quiz = new Quiz;
        $this->changeExamDB($quiz, $request);
        return redirect(route('admin.quiz.index'))->with('success', 'Quiz Added');
    }
    
    public function show($slug) {
        $quiz = Quiz::where("slug", $slug)->firstOrFail();
        $departments = Department::all();
        $quizDeptRelation = DB::table('department_quiz')
        ->join('departments', 'department_quiz.department_id', '=', 'departments.id')
        ->select('department_quiz.*', 'departments.*')
        ->where('department_quiz.quiz_id', $quiz->id)->get();
        
        return view("admin.quiz.show")->with([
            "title" => $quiz->title, 
            "quiz" => $quiz, 
            "relations" => $quizDeptRelation, 
            "departments" => $departments
        ]);
    }

    public function assign($id, Request $request) {
        $quiz = Quiz::findOrFail($id);

        DepartmentQuiz::create([
            "department_id" => $request->addDept,
            "quiz_id" => $quiz->id
        ]);

        return redirect()->back();
    }

    public function deassign($dept, $quiz) {
        $rel = DepartmentQuiz::where([['quiz_id', $quiz], ['department_id', $dept]])->firstOrFail();
        $rel->delete();

        return redirect()->back();
    }
    
    public function edit($slug) {
        $occasions = Occasion::all();
        $quiz = Quiz::where("slug", $slug)->firstOrFail();
        return view('admin.quiz.edit')->with([
            "title" => "Edit Quiz - ".$quiz->title, 
            "quiz" => $quiz,
            "occasions" => $occasions
        ]);
    }
    
    public function update($id, Request $request) {
        $quiz = Quiz::findOrFail($id);

        if(isset($request->quespdf)) {
            $this->deletePDF($quiz->quespdf);
        }

        if(isset($request->keypdf)) {
            $this->deletePDF($quiz->keypdf);
        }

        $this->changeExamDB($quiz, $request);

        return redirect(route('admin.quiz.index'))->with('success', 'Quiz Updated');
    }
    
    public function destroy($id) {
        $quiz = Quiz::findOrFail($id);

        $quiz->delete();
        
        return redirect()->back()->with('danger', 'Quiz Deleted');
    }
    
    public function deletePDF($pdf) {
        if($pdf != NULL) {
            if(file_exists(storage_path($pdf)))
                File::delete(storage_path($pdf));
        }
    }
}
