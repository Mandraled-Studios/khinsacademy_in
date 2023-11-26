<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Progress;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\DepartmentUser;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function departments() {
        $departments = Department::all();

        $deptUsers = DB::table('department_user')
                        ->join('departments', 'department_user.department_id', '=', 'departments.id')
                        ->select('departments.*')
                        ->where('department_user.user_id', auth()->user()->id)->get();
                                              
        return view('students.departments')->with([ 
            "title" => "Join a New Department Today",
            "departments" => $departments,
            "deptUsers" => $deptUsers 
        ]);
    }

    public function joinDepartment(Request $request) {
        $user_id = auth()->user()->id;
        $dept_id = $request->department;

        $du = new DepartmentUser;
        $du->user_id = $user_id;
        $du->department_id = $dept_id;
        $du->save();

        return redirect()->back()->with("success", "Joined New Department!");
    }

    public function quiz() {
        /*
        $quizzes = Quiz::where('publish_status', '1')->whereNotNull('published_at')->get();
 
        $filtered = $quizzes->filter(function (Quiz $value, int $key) {
            $quizAssignedTo = $value->departments;
            $userBelongsTo = DepartmentUser::where('user_id', auth()->user())

            if() {

            }
            return $value;
        });
        */

        $user = auth()->user();
        $userDepts = $user->departments;

        $filtered = DB::table('quizzes')
                          ->join('department_quiz', 'quizzes.id', '=', 'department_quiz.quiz_id')
                          ->join('departments', 'department_quiz.department_id', '=', 'departments.id')
                          ->join('department_user', 'departments.id', '=', 'department_user.department_id')
                          ->where([['department_user.user_id', '=', $user->id], ['quizzes.publish_status', '=', 1]])
                          ->select('quizzes.*', 'departments.title AS deptTitle', 'departments.description AS deptDesc', 'departments.icon AS icon')
                          ->groupBy('id')
                          ->get();

        return view('students.quizlist')->with([ 
            "quizzes" => $filtered,
            "title" => "All Exams" 
        ]);
    }

    public function reportCard() {
        $progresses = Progress::where('progress.user_id', auth()->user()->id)->get();
        return view('students.reportcard')->with([
            'progresses' => $progresses
        ]);
    }
}
