<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Progress;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function studentRegistrations() {
        $students = User::orderBy('created_at', 'desc')->paginate(24);
        $studentsCount = User::count();
        return view("admin.registrations")->with([
            "title" => "All Student Registrations",
            "students" => $students,
            "studentsCount" => $studentsCount,
        ]);
    }

    public function studentProfile($id) {
        $student = User::findOrFail($id);
        //$progresses = $student->progresses;
        return view("admin.studentProfile")->with([
            "title" => "Student Information",
            "student" => $student,
            //"progresses" => $progresses
        ]);
    }

    public function studentSearch(Request $request) {
        $students = User::where('name', 'like', '%'.$request->term.'%')->paginate(24);
        
        $studentsCount = User::where('name', 'like', '%'.$request->term.'%')->count();
        
        return view("admin.registrations")->with([
            "title" => "Search Results for '".$request->term."'",
            "students" => $students,
            "studentsCount" => $studentsCount,
        ]);
    }

    public function quizReports() {
        $quizzes = Quiz::whereNull('deleted_at')->whereNotNull('published_at')->get();
        return view('admin.reportFilter')->with([
            "quizzes" => $quizzes
        ]);
    }

    public function quizReportsIndividual($id) {
        $quiz = Quiz::findOrFail($id);
        $progresses = Progress::where('quiz_id', $quiz->id)->get();
        return view('admin.reportFilterIndividual')->with([
            "quiz" => $quiz,
            "progresses" => $progresses
        ]);
    }

    public function reportsViewIndividualStudent($quiz, $student){
        $user = User::findOrFail($student);
        $quiz = Quiz::findOrFail($quiz);
        $questions = Question::where('quiz_id', $quiz->id)->whereNull('deleted_at')->get();
        $progresses = $quiz->progresses->where("user_id", $student)->first();


        return view("admin.reports.individualStudent")->with([
            "title" => "Exam Reports - ".$quiz->title,
            "exam" => $quiz,
            "progresses" => $progresses,
            "questions" => $questions,
            "student" => $user
        ]);
    }
}
