<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function quiz() {
        $quizzes = Quiz::where('publish_status', '1')->whereNotNull('published_at')->get();

        return view('students.quizlist')->with([ 
            "quizzes" => $quizzes,
            "title" => "All Exams" 
        ]);
    }

    public function reportCard() {
        
    }
}
