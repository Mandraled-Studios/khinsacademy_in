<?php

namespace App\Http\Controllers;

use App\Models\Occasion;
use Illuminate\Http\Request;

class OccasionController extends Controller
{
    public function index() {
        $occasions = Occasion::all();
        
        return view('admin.occasion.index')->with([
                        "title" => "Occasions List",
                        "occasions" => $occasions
                    ]);
    }
    
    public function store(Request $request) {
        $data = $request->validate([
            'heading' => 'required|string|min:3|max:255',
            'banner' => 'nullable|sometimes|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        if($request->hasFile('banner')) {

            //Set only filename without ext
            $filename = substr(preg_replace('/[^A-Za-z]/', '', $data['heading']), 0, 40);  
            //Get extension of file
            $extension =  $request->file('banner')->getClientOriginalExtension();      
            //Filename to store in DB
            $filenameToStore = $filename . "-banner-" . random_int(1000,9999)."-". time() . "." . $extension; 
            
            $path = 'public/images/occasions/';  
            //Upload image to storage
            $imagePath = $request->file('banner')->storeAs($path, $filenameToStore); 
            $data['banner'] = "/storage/images/occasions/". $filenameToStore;
        } else {
            $data['banner'] = NULL;
        }

        $occasion = Occasion::create([
            "heading" => $data['heading'],
            "banner" => $data['banner'] 
        ]);

        return redirect()->back()->with(["success" => "Created new occasion"]);
    }
    public function update($id, Request $request) {
        $occasion = Occasion::findOrFail($id);

        $data = $request->validate([
            'heading' => 'required|string|min:3|max:255',
            'banner' => 'nullable|sometimes|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        if($request->hasFile('banner')) {

            //Set only filename without ext
            $filename = substr(preg_replace('/[^A-Za-z]/', '', $data['heading']), 0, 40);  
            //Get extension of file
            $extension =  $request->file('banner')->getClientOriginalExtension();      
            //Filename to store in DB
            $filenameToStore = $filename . "-banner-" . random_int(1000,9999)."-". time() . "." . $extension; 
            
            $path = 'public/images/occasions/';  
            //Upload image to storage
            $imagePath = $request->file('banner')->storeAs($path, $filenameToStore); 
            $data['banner'] = "/storage/images/occasions/". $filenameToStore;
        } else {
            $data['banner'] = NULL;
        }

        $occasion->update([
            "heading" => $data['heading'],
            "banner" => $data['banner'] 
        ]);

        return redirect()->back()->with(["success" => "Updated occasion successfully"]);
    }
    public function destroy($id) {
        $occasion = Occasion::findOrFail($id);
        $occasion->delete();
        
        return redirect()->back()->with(["danger" => "Deleted occasion"]);
    }
}
