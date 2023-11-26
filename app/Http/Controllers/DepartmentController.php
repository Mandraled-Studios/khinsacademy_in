<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index() {
        $departments = Department::all();
        
        return view('admin.departments.index')->with([
                        "title" => "Departments List",
                        "departments" => $departments
                    ]);
    }
    
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|sometimes|string|min:3|max:255',
            'icon' => 'nullable|sometimes|image|mimes:jpg,jpeg,png,svg|max:1024',
        ]);

        if($request->hasFile('icon')) {

            //Set only filename without ext
            $filename = substr(preg_replace('/[^A-Za-z]/', '', $data['title']), 0, 40);  
            //Get extension of file
            $extension =  $request->file('icon')->getClientOriginalExtension();      
            //Filename to store in DB
            $filenameToStore = $filename . "-icon-" . random_int(1000,9999)."-". time() . "." . $extension; 
            
            $path = 'public/images/departments/';  
            //Upload image to storage
            $imagePath = $request->file('icon')->storeAs($path, $filenameToStore); 
            $data['icon'] = "/storage/images/departments/". $filenameToStore;
        } else {
            $data['icon'] = NULL;
        }

        $department = Department::create([
            "title" => $data['title'],
            "description" => $data['description'],
            "icon" => $data['icon'] 
        ]);

        return redirect()->back()->with(["success" => "Created new department"]);
    }
    public function update($id, Request $request) {
        $department = Department::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|sometimes|string|min:3|max:255',
            'icon' => 'nullable|sometimes|image|mimes:jpg,jpeg,png,svg|max:1024',
        ]);

        if($request->hasFile('icon')) {

            //Set only filename without ext
            $filename = substr(preg_replace('/[^A-Za-z]/', '', $data['title']), 0, 40);  
            //Get extension of file
            $extension =  $request->file('icon')->getClientOriginalExtension();      
            //Filename to store in DB
            $filenameToStore = $filename . "-icon-" . random_int(1000,9999)."-". time() . "." . $extension; 
            
            $path = 'public/images/departments/';  
            //Upload image to storage
            $imagePath = $request->file('icon')->storeAs($path, $filenameToStore); 
            $data['icon'] = "/storage/images/departments/". $filenameToStore;
        } else {
            if($department->icon !== NULL) {
                $data['icon'] = $department->icon;
            } else {
                $data['icon'] = NULL;
            }
        }

        $department->update([
            "title" => $data['title'],
            "description" => $data['description'],
            "icon" => $data['icon'] 
        ]);

        return redirect()->back()->with(["success" => "Updated department successfully"]);
    }
    public function destroy($id) {
        $department = Department::findOrFail($id);
        $department->delete();
        
        return redirect()->back()->with(["danger" => "Deleted department"]);
    }
}
