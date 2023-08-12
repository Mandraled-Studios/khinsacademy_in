<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}
