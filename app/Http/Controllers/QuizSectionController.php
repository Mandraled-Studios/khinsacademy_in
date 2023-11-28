<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizSection;
use Illuminate\Http\Request;

class QuizSectionController extends Controller
{
    public function create($quiz) {
        $thisQuiz = Quiz::where('slug', $quiz)->firstOrFail();
        $quizSections = $thisQuiz->sections;
        
        return view("admin.quiz.sections.create")->with([
            "title" => "Create New Section",
            "quiz" => $thisQuiz,
            "quizSections" => $quizSections
        ]);
    }

    public function store($slug, Request $request) {

        $thisQuiz = Quiz::where('slug', $slug)->firstOrFail();

        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'max_marks' => 'required|numeric|min:1',
            'max_mins' => 'required|numeric|min:1'
        ]);

        QuizSection::create([
            'quiz_id' => $thisQuiz->id,
            'name' => $data['name'],
            'max_marks' => $data['max_marks'],
            'max_mins' => $data['max_mins'],
        ]);

        return redirect(route('admin.quiz.sections.create', ['slug' => $thisQuiz->slug]))->with([
            "success" => "Section created successfully"
        ]);
    }

    public function update($slug, $section, Request $request) {

        $thisQuiz = Quiz::where('slug', $slug)->firstOrFail();
        $section = QuizSection::where([
            ['id', $section],
            ['quiz_id', $thisQuiz->id],
        ])->firstOrFail();

        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'max_marks' => 'required|numeric|min:1',
            'max_mins' => 'required|numeric|min:1'
        ]);

        $section->update([
            'quiz_id' => $thisQuiz->id,
            'name' => $data['name'],
            'max_marks' => $data['max_marks'],
            'max_mins' => $data['max_mins'],
        ]);

        return redirect()->back()->with([
            "success" => "Section created successfully"
        ]);
    }

    public function destroy($slug, $section) {
        $thisQuiz = Quiz::where('slug', $slug)->firstOrFail();
        $thisSection = QuizSection::where([
            ['id', $section],
            ['quiz_id', $thisQuiz->id],
        ])->firstOrFail();

        $thisSection->questions()->delete();
        $thisSection->section_progress()->delete();

        $thisSection->delete();

        return redirect()->back()->with('danger', 'Quiz Section Deleted');

    }
}
