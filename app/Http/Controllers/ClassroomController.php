<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassroomController extends Controller
{
    public function changeClassroomsDB($newEntry, $classroom, $data) {
        $classroom->department_id = $data['department'];
        if($data['classYear'] == $data['examYear']) {
            $classroom->examYear = NULL;
        } else {
            $classroom->examYear = $data['examYear'];
        }
        $classroom->classYear = $data['classYear'];
        $classroom->save();
    }

    public function index() {
        $departments = Department::all();

        $classrooms = DB::table('departments')
            ->join('classrooms', 'departments.id', '=', 'classrooms.department_id')
            ->select('departments.*', 'classrooms.*')
            ->get();
            
        return view('admin.classrooms.index')->with(["title" => "All Class Room / Batches List", 
                                              "departments" => $departments,
                                              "classrooms" => $classrooms ]);
    }
    public function create() {
        $departments = Department::all();
        return view('admin.classrooms.create')->with([
            "title" => "Create A New Class Room / Batch",
            "departments" => $departments
        ]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'department' => 'required|integer|min:1|max:15',
            'examYear' => 'required|integer|min:2018|max:2100',
            'classYear' => 'required|integer|min:2018|max:2100',
        ]);

        $duplicate = Classroom->where([
                                        ['department_id', '=', $data['department']], 
                                        ['examYear', '=', $data['examYear']],
                                        ['classYear', '=', $data['classYear']]
                                    ])->first();
        if($duplicate == NULL) {
            $classroom = new Classroom;
            $this->changeClassroomsDB(true, $classroom, $data);
            return redirect(route('admin.classrooms.index'))->with(["success" => "The Classroom / Batch has been created"]);
        } else {
            return redirect()->back()->with(["danger" => "The Classroom / Batch already exists"]);
        }
    }
    public function destroy($id) {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();

        return redirect()->back()->with(["danger" => "The Classroom / Batch has been deleted"]);

    }
}
